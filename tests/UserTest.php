<?php

require_once(dirname(__FILE__, 2).'/app/Config/config.php');

class UserTest extends \PHPUnit\Framework\TestCase{
    /**
     * Holds the user_id to use in subsequent tests
     * @var string
     */
    private $user_id;
    /**
     * @var \App\Models\User
     */
    private $user;

    protected function setUp(): void {
        $this->user = new \App\Models\User;
    }

    protected function tearDown(): void
    {

    }

    public function testThatWeCanGetTheFirstName():void {

        $this->user->setFirstName('John');

        $this->assertEquals('John', $this->user->getFirstName());
    }

    public function testThatWeCanGetLastName():void {

        $this->user->setLastName('Smith');

        $this->assertEquals('Smith', $this->user->getLastName());
    }

    public function testThatWeCanGetTheEmailAddress():void {

        $this->user->setEmailAddress('johnsmith@company.co');

        $this->assertEquals('johnsmith@company.co', $this->user->getEmailAddress());
    }

    public function testThatWeCanGetTheRoleId(): void {

        $this->user->setRoleId(3);

        $this->assertEquals(3, $this->user->getRoleId());
    }


}

