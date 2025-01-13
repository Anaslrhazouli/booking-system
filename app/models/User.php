<?php
class User extends Model {
    protected $table = 'users';
    
    public function create($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return parent::insert($data);
    }
    
    public function authenticate($email, $password) {
    $user = $this->findOne(['email' => $email]);

    // Debug to check if user data is correct
    var_dump($user); // This should include the 'name' field

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

}