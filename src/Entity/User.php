<?php


namespace App\Entity;


use App\Security\Roles;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /**
     * @var UuidInterface
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string[]
     */
    protected $roles;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @throws \Exception
     */
    public function __construct(string $name, string $password, UuidInterface $id=null, string $email=null)
    {
        $this->name = $name;
        $this->setPassword($password);
        $this->id = $id ?? Uuid::uuid4();
        $this->email = $email;
        $this->roles= [Roles::ROLE_USER];
        $this->createdAt= new \DateTime();
        $this->markAsUpdated();
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }



    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function getSalt(): void
    {
    }

    public function getUsername():?string
    {
       return $this->email;
    }

    public function eraseCredentials():void
    {

    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }


    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @throws \Exception
     */
    public function markAsUpdated(){
        $this->updatedAt= new \DateTime();
    }
}