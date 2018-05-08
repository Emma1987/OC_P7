<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Token;
use Firebase\JWT\JWT;
use App\Exception\InvalidTokenException;

class TokenManager
{
    /**
     * The key used to encode the JWT
     * @var string
     */
    private $key;

    public function __construct()
    {
        $this->key = 'BileMoAPI';
    }

    /**
     * Encode client informations in JWT
     * @param User $user
     * @return string $token
     */
    public function getJWT(User $user)
    {
        $accessToken = [
            'iss'       => 'BileMo phones',
            'id'        => $user->getId(),
            'username'  => $user->getUsername(),
            'role'      => $user->getRoles(),
            'exp'       => time() + 3600
        ];
        
        $accessToken = JWT::encode($accessToken, $this->key);
        $generatedAt = date_format(new \Datetime('now', new \DateTimeZone("Europe/Amsterdam")), 'd-m-Y H:i:s');
        $expireAt = date_format(new \Datetime('now +1 hour', new \DateTimeZone("Europe/Amsterdam")), 'd-m-Y H:i:s');

        return $token = new Token($accessToken, $generatedAt, $expireAt);
    }

    /**
     * Verify the JWT
     * @param string $token
     * @return array $tokenInformations [Array of JWT informations]
     */
    public function decodeJWT($token)
    {
        if (empty($token)) {
            throw new InvalidTokenException('Aucun token n\'a été envoyé');
        }

        try {
            $decoded = JWT::decode($token, $this->key, array('HS256'));
        } catch (\Exception $e) {
            if ($e->getMessage() === 'Expired token') {
                throw new InvalidTokenException('Ce token est expiré, merci de vous reconnecter pour en obtenir un nouveau');
            } else {
                throw new InvalidTokenException('Ce token n\'est pas valide');
            }
        }

        return $tokenInformations = (array) $decoded;
    }
}