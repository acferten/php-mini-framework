<?php

namespace Src\Auth;

use Src\Session;
use Firebase\JWT\JWT;

class Auth
{
    //Свойство для хранения любого класса, реализующего интерфейс IdentityInterface
    private static IdentityInterface $user;

    //Инициализация класса пользователя
    public static function init(IdentityInterface $user): void
    {
        self::$user = $user;
        if (self::user()) {
            self::login(self::user());
        }
    }

    //Генерация нового токена для CSRF
    public static function generateCSRF(): string
    {
        $token = md5(time());
        Session::set('csrf_token', $token);
        return $token;
    }


    //Вход пользователя по модели
    public static function login(IdentityInterface $user): void
    {
        self::$user = $user;
        Session::set('id', self::$user->getId());
    }

    //Аутентификация пользователя и вход по учетным данным
    public static function attempt(array $credentials): bool
    {
        if ($user = self::$user->attemptIdentity($credentials)) {
            self::login($user);
            return true;
        }
        return false;
    }

    //Возврат текущего аутентифицированного пользователя
    public static function user()
    {
        $id = Session::get('id') ?? 0;
        return self::$user->findIdentity($id);
    }

    //Проверка является ли текущий пользователь аутентифицированным
    public static function check(): bool
    {
        if (self::user()) {
            return true;
        }
        return false;
    }

    //Выход текущего пользователя
    public static function logout(): bool
    {
        Session::clear('id');
        return true;
    }

    public function hasValidCredentials(): bool
    {
        // TODO: написать валидацию
    }

    public function generateToken()
    {
        if ($this->hasValidCredentials()) {
            $secretKey = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
            $tokenId = base64_encode(random_bytes(16));
            $issuedAt = new DateTimeImmutable();
            $expire = $issuedAt->modify('+6 minutes')->getTimestamp();      // Add 60 seconds
            $serverName = "your.domain.name";
            $username = "username";                                           // Retrieved from filtered POST data

            // Create the token as an array
            $data = [
                'iat' => $issuedAt->getTimestamp(),    // Issued at: time when the token was generated
                'jti' => $tokenId,                     // Json Token Id: an unique identifier for the token
                'iss' => $serverName,                  // Issuer
                'nbf' => $issuedAt->getTimestamp(),    // Not before
                'exp' => $expire,                      // Expire
                'data' => [                             // Data related to the signer user
                    'userName' => $username,            // User name
                ]
            ];

            // Encode the array to a JWT string.
            echo JWT::encode(
                $data,      //Data to be encoded in the JWT
                $secretKey, // The signing key
                'HS512'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
            );
        }
    }

}
