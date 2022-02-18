<?php

use App\Models\Role;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase {
    
    public function testThatWeCanGetARoleName(): void {
        $role = new Role;
        
        $role->setRoleName('Janitor');
        
        $this->assertEquals('Janitor', $role->getRoleName());
    }
}

