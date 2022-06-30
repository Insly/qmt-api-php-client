<?php

namespace Insly\QmtApiClient\Api\Endpoints;

use Insly\QmtApiClient\Api\Models\Broker;
use Insly\QmtApiClient\Api\Models\Group;
use Insly\QmtApiClient\Api\Models\Role;
use Insly\QmtApiClient\Api\Models\User;
use Insly\QmtApiClient\Api\Responses\JsonResponse;
use Insly\QmtApiClient\Api\Responses\ResultsResponse;
use Insly\QmtApiClient\Api\Transformers\Master\BrokersListTransformer;
use Insly\QmtApiClient\Api\Transformers\Master\BrokerTransformer;
use Insly\QmtApiClient\Api\Transformers\Master\GroupsListTransformer;
use Insly\QmtApiClient\Api\Transformers\Master\GroupTransformer;
use Insly\QmtApiClient\Api\Transformers\Master\RolesListTransformer;
use Insly\QmtApiClient\Api\Transformers\Master\RoleTransformer;
use Insly\QmtApiClient\Api\Transformers\Master\UsersListTransformer;
use Insly\QmtApiClient\Api\Transformers\Master\UserTransformer;

class MasterServiceEndpoint extends AbstractServiceEndpoint
{
    /**
     * @var string
     */
    protected $service = 'master';

    /**
     * @param array $queryParams
     * @return ResultsResponse
     */
    public function adminGetUsersList(array $queryParams = []): ResultsResponse
    {
        return new ResultsResponse(
            $this->client->get(
                $this->tenantPath('/admin/users'),
                $queryParams
            ),
            new UsersListTransformer()
        );
    }

    /**
     * @param User $user
     * @return User
     */
    public function adminCreateUser(User $user): User
    {
        $response = new JsonResponse(
            $this->client->post(
                $this->tenantPath('/admin/users'),
                (new UserTransformer())->reverseTransform($user->getFields())
            )
        );

        $result = new User();
        $result->setFields(
            (new UserTransformer())
                ->transform($response->getJson())
        );

        return $result;
    }

    /**
     * @param array $queryParams
     * @return ResultsResponse
     */
    public function adminGetBrokersList(array $queryParams = []): ResultsResponse
    {
        return new ResultsResponse(
            $this->client->get(
                $this->tenantPath('/admin/brokers'),
                $queryParams
            ),
            new BrokersListTransformer()
        );
    }

    /**
     * @param Broker $result
     * @return Broker
     */
    public function adminCreateBroker(Broker $broker): Broker
    {
        $response = new JsonResponse(
            $this->client->post(
                $this->tenantPath('/admin/brokers'),
                (new BrokerTransformer())->reverseTransform($broker->getFields())
            )
        );

        $result = new Broker();
        $result->setFields(
            (new BrokerTransformer())
                ->transform($response->getJson())
        );

        return $result;
    }

    /**
     * @param array $queryParams
     * @return ResultsResponse
     */
    public function adminGetGroupsList(array $queryParams = []): ResultsResponse
    {
        return new ResultsResponse(
            $this->client->get(
                $this->tenantPath('/admin/groups'),
                $queryParams
            ),
            new GroupsListTransformer()
        );
    }

    /**
     * @param Group $group
     * @return Group
     */
    public function adminCreateGroup(Group $group): Group
    {
        $response = new JsonResponse(
            $this->client->post(
                $this->tenantPath('/admin/groups'),
                (new GroupTransformer())->reverseTransform($group->getFields())
            )
        );

        $result = new Group();
        $result->setFields(
            (new GroupTransformer())
                ->transform($response->getJson())
        );

        return $result;
    }

    /**
     * @param string $groupId
     * @param array $queryParams
     * @return ResultsResponse
     */
    public function adminGetRolesList(string $groupId, array $queryParams = []): ResultsResponse
    {
        return new ResultsResponse(
            $this->client->get(
                $this->tenantPath('/admin/groups/' . $groupId . '/roles'),
                $queryParams
            ),
            new RolesListTransformer()
        );
    }

    /**
     * @param string $groupId
     * @param Role $role
     * @return Role
     */
    public function adminCreateRole(string $groupId, Role $role): Role
    {
        $response = new JsonResponse(
            $this->client->post(
                $this->tenantPath('/admin/groups/' . $groupId . '/roles'),
                (new RoleTransformer())->reverseTransform($role->getFields())
            )
        );

        $result = new Role();
        $result->setFields(
            (new RoleTransformer())
              ->transform($response->getJson())
        );

        return $result;
    }
}
