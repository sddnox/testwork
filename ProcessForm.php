<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


class FormHandler {
    private $name;
    private $email;
    private $phone;
    private $price;

    public function __construct($postData) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->name = $postData["name"];
            $this->email = $postData["email"];
            $this->phone = $postData["phone"];
            $this->price = $postData["price"];
            $this->processFormData();
        }
    }

    private function processFormData() {
        require_once 'Contact.php';
        require_once "access.php";
        require_once "Lead.php";  
        
        $dataContact = [
            [
                "first_name" => $this->name,
                "custom_fields_values" => [
                    [
                        "field_code" => "EMAIL",
                        "values" => [ 
                            [
                                "enum_code" => "WORK",
                                "value" => $this->email,
                            ]
                        ]
                    ],
                    [
                        "field_code" => "PHONE",
                        "values" => [
                            [
                                "enum_code" => "WORK",
                                "value" => $this->phone,
                            ]
                        ]
                    ],
                ]                
            ]

        ];

        $contact = new Contact($access_token, $subdomain);
        $idContact = $contact->add($dataContact);
       
        $amoClient = new Lead($access_token, $subdomain);

        $data = [
            [
                "name" => $this->name,
                "price" => (int)$this->price,
                '_embedded' => [
                    'contacts' => [
                        [
                            'id' => $idContact

                        ]
                    ]
                ],
            ]

        ];
      
        
        $idlead = $amoClient->createLead($data);

        

        echo "Была создана сделка с ID: " . $idlead . " и контакт ID: " . $idContact;
    }
}

$formHandler = new FormHandler($_POST);