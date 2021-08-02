<?php defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
require_once APPPATH . 'libraries/API_Controller.php';
include APPPATH.'/third_party/faker/autoload.php';
include APPPATH.'enumerations/StateEnum.php';
include APPPATH.'enumerations/ContractEnum.php';
include APPPATH.'enumerations/AnnonceTypeEnum.php';  

class DatabaseFixture extends API_Controller
{
    public function __construct() {
        parent::__construct();
    }

    /**
     * demo method 
     *
     * @link [api/user/demo]
     * @method POST
     * @return Response|void
     */
    

    /**
     * Check API Key
     *
     * @return key|string
     */
    private function key()
    {
        // use database query for get valid key

        return 1452;
    }


    /**
     * login method 
     *
     * @link [api/user/login]
     * @method GET
     * @return Response|void
     */
    public function configure()
    {
        header("Access-Control-Allow-Origin: *");
        set_time_limit(500);
        // API Configuration
        $this->_apiConfig([
            'methods' => ['GET'],
            // 'requireAuthorization' => true,
        ]);
        $this->load->dbforge();
        
        $this->set_tables();


        // return data
        $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('status' => true,"data" => "configure")));
    }

    function set_tables(){
        $this->configure_menu_tables();
       //  $this->configure_api_tables();
        
       //  $this->configure_picklist_table();
       
       //  $this->configure_users_table();
       //  $this->configure_jobs_table();
       //  $this->configure_fixture();
       //  $this->configure_annonce_table();
       //  $this->configure_vente_table();
       //  $this->configure_flash_annonce_table();
       //  $this->configure_image_table();
       //  $this->configure_rencontre_table();
         
       //  $this->fake_user();
        
       // $this->fake_annonce();
       // $this->fake_rencontre();
       // $this->fake_vente();
       //  $this->fake_flashannonce();

    }

    public function configure_picklist_table(){
        $menu_fields = array(
            'groupe' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'value' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'is_deleted' => array(
                'type' => 'BOOLEAN',
            ),
        );
        $this->dbforge->add_field($menu_fields);
        $this->dbforge->add_field('picklist_id VARCHAR(100) NOT NULL PRIMARY KEY');
        $this->dbforge->create_table('picklists', true); 

    }

    public function configure_api_tables(){
        $api_limits = "CREATE TABLE IF NOT EXISTS  `api_limit` (
        `id` INT NOT NULL AUTO_INCREMENT ,  
        `user_id` INT NULL DEFAULT NULL ,  
        `uri` VARCHAR(200) NOT NULL ,  
        `class` VARCHAR(200) NOT NULL ,  
        `method` VARCHAR(200) NOT NULL ,  
        `ip_address` VARCHAR(50) NOT NULL ,  
        `time` TEXT NOT NULL ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB;";


        $api_keys = "CREATE TABLE IF NOT EXISTS  `api_keys` ( 
        `id` INT NOT NULL AUTO_INCREMENT ,  
        `api_key` VARCHAR(50) NOT NULL ,  
        `controller` VARCHAR(50) NOT NULL ,  
        `date_created` DATE NULL DEFAULT NULL ,  
        `date_modified` DATE NULL DEFAULT NULL ,    PRIMARY KEY  (`id`)
    ) ENGINE = InnoDB;";
    $this->db->query($api_limits, true);
    $this->db->query($api_keys, true);
}
function configure_fixture(){

   $pick = array(
    'picklist_id'=>'',
    'groupe'=>'CATEGORY',
    'value'=>"all"
);
   $pick2 = array(
    'picklist_id'=>'',
    'groupe'=>'CATEGORY',
    'value'=>"exemple"
);
   $this->PicklistModel->savePickList($pick);
   $this->PicklistModel->savePickList($pick2);
}

public function configure_users_table(){
    $fields = array(
        'username' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            'unique' => FALSE,
        ),
        'email' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            'unique' => FALSE,
        ),
        'photo' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            'unique' => FALSE,
        ),
        'firstName' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            'unique' => FALSE,
        ),
        'phone' => array(
            'type' => 'VARCHAR',
            'constraint' => '20',
            'unique' => FALSE,
        ),
        'lastName' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            'unique' => FALSE,
        ),
        'nationality' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            'unique' => FALSE,
        ),
        'birthDate' => array(
            'type' => 'DATETIME',

            'unique' => FALSE,
        ),
        'password' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',

            'unique' => FALSE,
        ),
        'sexe' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',

            'unique' => FALSE,
        ),
    );
    $user_status_fields = array(

        'isDeleted' => array(
            'type' => 'BOOLEAN',
        ),
        'user_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',

        ),
        'isAdmin' => array(
            'type' => 'BOOLEAN',
        ),
        'isActive' => array(
            'type' => 'BOOLEAN',
        ),
    );

    $this->dbforge->add_field($fields);
    $this->dbforge->add_field('user_id VARCHAR(500) NOT NULL  PRIMARY KEY');
    $this->dbforge->create_table('users', true);
        // user status
    $this->dbforge->add_field($user_status_fields);
    $this->dbforge->add_field('status_id VARCHAR(500) NOT NULL');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(user_id)');
    $this->dbforge->create_table('user_status', true);
}

function configure_jobs_table(){

    $jobs_fields = array(

        'reference' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ), 
        'profile' => array(
            'type' => 'TEXT',
            'constraint' => '200',
        ),
        'poste' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'society' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'mission' => array(
            'type' => 'TEXT',
            'constraint' => '250',
        ),
        'contract' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'description' => array(
            'type' => 'TEXT',
            'constraint' => '250',
        ),
        'date' => array(
            'type' => 'DATETIME',
        ),
        'societyDescription' => array(
            'type' => 'TEXT',
            'constraint' => '250',
        ),
        'salary' => array(
            'type' => 'DECIMAL',
        ),
        'state_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',

        ),
        'user_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'category_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'is_deleted' => array(
            'type' => 'BOOLEAN',
        ),
    );

    $state_fields = array(
        'isExpired' => array(
            'type' => 'BOOLEAN',
        ),
        'isPayed' => array(
            'type' => 'BOOLEAN',
        ),
        'text' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
    );
    $this->dbforge->add_field($state_fields);
    $this->dbforge->add_field('state_id VARCHAR(100) NOT NULL PRIMARY KEY');
    $this->dbforge->create_table('state', true);

    $this->dbforge->add_field($jobs_fields);
    $this->dbforge->add_field('job_id VARCHAR(100) NOT NULL PRIMARY KEY');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(user_id)');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (category_id) REFERENCES picklists(picklist_id)');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (state_id) REFERENCES state(state_id)');
    $this->dbforge->create_table('jobs', true);
    
    $job_followers_relation_table = array(
        'user_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'job_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),

    );
    $this->dbforge->add_field($job_followers_relation_table);
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(user_id)');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (job_id) REFERENCES jobs(job_id)');
    $this->dbforge->create_table('job_followers', true);
}

function fake_user(){
    $faker = Faker\Factory::create();
    $this->State->saveState(
        array(
            "isExpired"=> true,
            "isPayed"=> false,
            "text"=> StateEnum::EXPIRED_NOT_PAYED,
            "state_id"=> $this->Guid->newGuid(),
        )
    );
    $this->State->saveState(
        array(
            "isExpired"=> false,
            "isPayed"=> true,
            "text"=> StateEnum::PAYED_NOT_EXPIRED,
            "state_id"=> $this->Guid->newGuid(),
        )
    );
    $this->State->saveState(
        array(
            "isExpired"=> true,
            "isPayed"=> true,
            "text"=> StateEnum::PAYED_EXPIRED,
            "state_id"=> $this->Guid->newGuid(),
        )
    );
    $contract_array = array(ContractEnum::CDD, ContractEnum::CDI, ContractEnum::FREELANCE);

    $nao = array(
        'user_id'=> "",
        'email'=>'naojulius.mg@gmail.com',
        'photo'=>'user.png',
        'firstName'=> 'NAO',
        'lastName'=>'julius',
        'username'=>'naojulius',
        'password'=> "1230", 
        'sexe'=>"Homme",
    );
    $this->UserModel->saveUser($nao);


    for ($i=0; $i < 100 ; $i++) { 
        $user = array(
            'user_id'=> "",
            'email'=> $faker->freeEmail,
            'photo'=>'user.png',
            'firstName'=> $faker->firstName,
            'lastName'=>$faker->lastName,
            'username'=>$faker->userName,
            'phone'=>$faker->e164PhoneNumber,
            'password'=> "1230",
            'sexe'=>"Femme",
        );
        $this->UserModel->saveUser($user);
    }

    for ($i=0; $i < 100 ; $i++) {
        $rand_contract_key = array_rand($contract_array);
        $rand_state = $this->State->getRandom();

        $rand_user =  $this->UserModel->getRandomUser();   
        $rand_picklist = $this->PicklistModel->getRandom();
        $job = array(
            'poste' =>  $faker->jobTitle,                
            'society' => $faker->company,
            'contract' => $contract_array[$rand_contract_key],
            'description' => $faker->realText($maxNbChars = 250, $indexSize = 4) ,
            'societyDescription' => $faker->text($maxNbChars = 100),
            'salary' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
            'state_id' => $rand_state->state_id,
            'user_id' => $rand_user->user_id,
            'category_id'=>$rand_picklist->picklist_id,
        );
        $this->JobModel->saveJob($job);
    }
}
function configure_annonce_table(){
    $fields = array(
        'title' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            
        ),
        'reference' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            'unique' => TRUE,
        ),
        'marque' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            'unique' => FALSE,
        ),
        'date' => array(
            'type' => 'DATETIME',
            
        ),
        'description' => array(
            'type' => 'TEXT',
            'constraint' => '250',
            'unique' => FALSE,
        ),
        'price' => array(
            'type' => 'DECIMAL',

        ),
        'type_annonce' => array(
            'type' => 'VARCHAR',
            'constraint' => '20',
        ),
        'state_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',

        ),
        'user_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'category_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'is_deleted' => array(
            'type' => 'BOOLEAN',
        ),
    );
    $this->dbforge->add_field($fields);
    $this->dbforge->add_field('annonce_id VARCHAR(100) NOT NULL PRIMARY KEY');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(user_id)');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (category_id) REFERENCES picklists(picklist_id)');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (state_id) REFERENCES state(state_id)');

    $this->dbforge->create_table('annonces', true);



    $annonce_followers_relation_table = array(
        'user_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'annonce_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),

    );
    $this->dbforge->add_field($annonce_followers_relation_table);
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(user_id)');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (annonce_id) REFERENCES annonces(annonce_id)');
    $this->dbforge->create_table('annonce_followers', true);

}
public function fake_annonce(){
     $faker = Faker\Factory::create();
     $type_annonce_array = array(AnnonceTypeEnum::SERVICE, AnnonceTypeEnum::ANNONCE);
    for ($i=0; $i < 100 ; $i++) {
        $rand_type_key = array_rand($type_annonce_array);

        $rand_state = $this->State->getRandom();
        $rand_user =  $this->UserModel->getRandomUser();   
        $rand_picklist = $this->PicklistModel->getRandom();
        $annonce = array(
            'title' =>  $faker->jobTitle,                
            'marque' => $faker->company,
            'description' => $faker->realText($maxNbChars = 250, $indexSize = 4) ,
            'price' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
            'state_id' => $rand_state->state_id,
            'user_id' => $rand_user->user_id,
            'category_id'=>$rand_picklist->picklist_id,
            'type_annonce'=>$type_annonce_array[$rand_type_key],
        );
        $this->AnnonceModel->saveAnnonce($annonce);
    }
}

public function fake_vente(){
    $faker = Faker\Factory::create();
    // $type_annonce_array = array(AnnonceTypeEnum::SERVICE, AnnonceTypeEnum::ANNONCE);
    for ($i=0; $i < 100 ; $i++) {
        //$rand_type_key = array_rand($type_annonce_array);

        $rand_state = $this->State->getRandom();
        $rand_user =  $this->UserModel->getRandomUser();   
        $rand_picklist = $this->PicklistModel->getRandom();
        $vente = array(
            'title' =>  $faker->jobTitle,                
            'marque' => $faker->company,
            'description' => $faker->realText($maxNbChars = 250, $indexSize = 4) ,
            'price' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
            'state_id' => $rand_state->state_id,
            'user_id' => $rand_user->user_id,
            'category_id'=>$rand_picklist->picklist_id,
        );
        $this->VenteModel->saveVente($vente);
    }
}

    public function configure_image_table(){
         $images = array(
                'value' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ),
                'annonce_id' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null'=>true
                ),
                'vente_id' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null'=>true
                ),
                'flashannonce_id' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null'=>true
                ),
            );
            $this->dbforge->add_field($images);
            $this->dbforge->add_field('image_id VARCHAR(100) NOT NULL PRIMARY KEY');
            $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (annonce_id) REFERENCES annonces(annonce_id)');
             $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (flashannonce_id) REFERENCES flashannonces(flashannonce_id)');
            $this->dbforge->create_table('images', true); 
    }

    function configure_vente_table(){
     $fields = array(
        'title' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            
        ),
         'reference' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            
        ),
          'description' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            
        ),
          'date' => array(
            'type' => 'DATETIME',
            
        ),
          'price' => array(
            'type' => 'DECIMAL',
        ),
          'marque' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            
        ),

        
        'state_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',

        ),
        'user_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'category_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'is_deleted' => array(
            'type' => 'BOOLEAN',
        ),
    );
    $this->dbforge->add_field($fields);
    $this->dbforge->add_field('vente_id VARCHAR(100) NOT NULL PRIMARY KEY');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(user_id)');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (category_id) REFERENCES picklists(picklist_id)');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (state_id) REFERENCES state(state_id)');
    $this->dbforge->create_table('ventes', true);



    $vente_followers_relation_table = array(
        'user_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'vente_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),

    );
    $this->dbforge->add_field($vente_followers_relation_table);
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(user_id)');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (vente_id) REFERENCES ventes(vente_id)');
    $this->dbforge->create_table('vente_followers', true);


    }
    function configure_rencontre_table(){
         $fields = array(
        'reference' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            
        ),
        'description' => array(
            'type' => 'TEXT',
            'constraint' => '250',
            
        ),
        'date' => array(
            'type' => 'DATETIME',
            
        ),
        
        'state_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',

        ),
        'user_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'category_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'is_deleted' => array(
            'type' => 'BOOLEAN',
        ),
    );
    $this->dbforge->add_field($fields);
    $this->dbforge->add_field('rencontre_id VARCHAR(100) NOT NULL PRIMARY KEY');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(user_id)');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (category_id) REFERENCES picklists(picklist_id)');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (state_id) REFERENCES state(state_id)');
    $this->dbforge->create_table('rencontres', true);



    $rencontre_followers_relation_table = array(
        'user_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'rencontre_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),

    );
    $this->dbforge->add_field($rencontre_followers_relation_table);
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(user_id)');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (rencontre_id) REFERENCES rencontres(rencontre_id)');
    $this->dbforge->create_table('rencontre_followers', true);

    
    }
    function fake_rencontre(){
        $faker = Faker\Factory::create();
        

        $rand_state = $this->State->getRandom();
        $rand_user =  $this->UserModel->getRandomUser();   
        $rand_picklist = $this->PicklistModel->getRandom();
        for ($i=0; $i < 100; $i++) { 
           $rencontre = array(
            'description' => $faker->realText($maxNbChars = 250, $indexSize = 4) ,
            'state_id' => $rand_state->state_id,
            'user_id' => $rand_user->user_id,
            'category_id'=>$rand_picklist->picklist_id,
            
         );
          $this->RencontreModel->saveRencontre($rencontre); 
        }
    }
    function configure_flash_annonce_table(){
     $fields = array(
        'title' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            
        ),
        'reference' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            
        ),
         'link' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            
        ),
          'image' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            
        ),
          'date' => array(
            'type' => 'DATETIME',
            
        ),
        'state_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',

        ),
        'user_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'category_id' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'is_deleted' => array(
            'type' => 'BOOLEAN',
        ),
    );
    $this->dbforge->add_field($fields);
    $this->dbforge->add_field('flashannonce_id VARCHAR(100) NOT NULL PRIMARY KEY');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(user_id)');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (category_id) REFERENCES picklists(picklist_id)');
    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (state_id) REFERENCES state(state_id)');
    $this->dbforge->create_table('flashannonces', true);
    }

    public function fake_flashannonce(){
        $faker = Faker\Factory::create();
        $rand_state = $this->State->getRandom();
        $rand_user =  $this->UserModel->getRandomUser();   
        $rand_picklist = $this->PicklistModel->getRandom();
        for ($i=0; $i < 10; $i++) { 
           $fls = array(
            'title'=>$faker->bothify('?????-#####'),
            "image"=> "soarano.png",
            'link' => "https://test_image",
            'state_id' => $rand_state->state_id,
            'user_id' => $rand_user->user_id,
            'category_id'=>$rand_picklist->picklist_id,
         );
          $this->FlashAnnonceModel->saveFlashAnnonce($fls); 
        }
    }
public function configure_menu_tables(){
    $menus_table = array(
        'level' => array(
            'type' => 'INT',
        ),
        'value' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),
        'key' => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
        ),

    );
    $this->dbforge->add_field($menus_table);
    $this->dbforge->add_field('menu_id VARCHAR(100) NOT NULL PRIMARY KEY');
    $this->dbforge->create_table('menus', true);
}
}
