<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Firebase\JWT\JWT;
use Tuupola\Base62;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserUnauthorizedException;
use App\Domain\User\UserBadRequestException;

class LoginUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        if (!isset($this->request->getParsedBody()['login']) || empty($this->request->getParsedBody()['login'])) {
            throw new UserBadRequestException();
        }
        if (!isset($this->request->getParsedBody()['password']) || empty($this->request->getParsedBody()['password'])) {
            throw new UserBadRequestException();
        }

        $login = $this->request->getParsedBody()['login'];
        $password = $this->request->getParsedBody()['password'];
        $user = User::where('login', '=', $login)->first();

        if (!$user)
            throw new UserUnauthorizedException();

        if (!password_verify($password, $user->password)) {
            throw new UserUnauthorizedException();
        }

        $scopes = [
            "chapter.create",
            "chapter.read",
            "chapter.update",
            "chapter.delete",
            "chapter.list",
            "chapter.all"
        ];
    
        $now = new \DateTime();
        $future = new \DateTime("now +2 hours");
        $server = $this->request->getServerParams();
    
        $jti = (new Base62)->encode(random_bytes(16));
    
        $payload = [
            "iat" => $now->getTimeStamp(),
            "exp" => $future->getTimeStamp(),
            "jti" => $jti,
            "sub" => $user->id,
            "scope" => $scopes
        ];
    
        $secret = getenv("JWT_SECRET") ?: 'secret';
        $token = JWT::encode($payload, $secret, "HS256");

        $data = $user;
        unset($data["password"]);
    
        $data["token"] = $token;
        $data["expires"] = $future->getTimeStamp();
    
        $this->logger->info("User of id `${user}` logged in.");

        return $this->respondWithData($data);
    }
}
