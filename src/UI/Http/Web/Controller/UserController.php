<?php

namespace App\UI\Http\Web\Controller;

use App\Application\User\Command\CreateUser;
use App\Application\User\Query\UserList\UserListParams;
use App\Infrastructure\User\Query\DoctrineLangListQuery;
use App\Infrastructure\User\Query\DoctrineUserListQuery;
use App\UI\Http\Web\Form\CreateUserType;
use App\UI\Http\Web\Form\UserListParamsType;
use Exception;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * UserController constructor.
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("", name="user_list")
     * @param Request $request
     * @param DoctrineUserListQuery $query
     *
     * @return Response
     */
    public function listAction(Request $request, DoctrineUserListQuery $query): Response
    {
        $params = UserListParams::fromRequest($request);

        $form = $this->createForm(UserListParamsType::class, $params);
        $form->handleRequest($request);

        $results = $query->execute($params);

        return $this->render('user/list.html.twig', [
            'results' => $results,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/langs", name="lang_list")
     * @param DoctrineLangListQuery $query
     *
     * @return Response
     */
    public function langListAction(DoctrineLangListQuery $query): Response
    {
        $results = $query->execute();

        return $this->render('user/langList.html.twig', [
            'results' => $results,
        ]);
    }

    /**
     * @Route("/create", name="user_create")
     * @param Request $request
     *
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $newUuid = Uuid::uuid4()->toString();
        $data = new CreateUser($newUuid);

        $error = '';
        $form = $this->createForm(CreateUserType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = $form->getData();

            try {
                $this->commandBus->handle($command);

                return $this->redirectToRoute('user_list');
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }
}
