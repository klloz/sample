<?php

namespace App\UI\Http\Rest\Controller;

use App\Application\User\Command\CreateUser;
use Exception;
use JMS\Serializer\SerializerInterface;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/users")
 *
 * Class UserController
 */
class UserController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * UserController constructor.
     *
     * @param CommandBus $commandBus
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(CommandBus $commandBus, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route("/create",
     *     name="api_user_create",
     *     methods={"POST"}
     * )
     *
     * @var Request
     *
     * @return Response
     */
    public function createUserAction(Request $request)
    {
        $uuid = Uuid::uuid4()->toString();

        /** @var CreateUser $command */
        $command = $this->serializer->deserialize($request->getContent(), CreateUser::class, 'json');
        $command->uuid = $uuid;

        $errors = $this->validator->validate($command);

        if ($errors->count() === 0) {
            try {
                $this->commandBus->handle($command);

                return new JsonResponse($uuid);
            } catch (Exception $e) {
                return new JsonResponse($e->getMessage());
            }
        }

        return new JsonResponse($errors);
    }
}
