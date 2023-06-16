<?php
if (!defined('JATBI'))
    die("Hacking attempt");
$school_id = $_SESSION['school'];
$school = $database->get("school", "*", ["id" => $school_id, "deleted" => 0, "status" => 'A']);
$students = $database->select("students", "*", ["school" => $school_id, "deleted" => 0, "status" => 'A']);
$course = $database->select("course", "*", ["school" => $school_id, "deleted" => 0, "status" => 'A']);
$allergy = $database->select("allergy", "*", ["school" => $school_id, "deleted" => 0, "status" => 'A']);
$school_parents = $database->select("school_parent", "*", [
    'school' => $school_id,
    "deleted" => 0,
    "status" => 'A',
    "ORDER" => [
        "id" => "DESC",
    ]
]);
$school_teachers = $database->select("school_teacher", "*", ['school' => $school_id, "deleted" => 0, "status" => 'A']);
$parent = $database->select("parent", "*", ["deleted" => 0, "status" => 'A']);
$province = $database->select("province", "*", ["school" => $school_id, "deleted" => 0, "status" => 'A']);
$district = $database->select("district", "*", ["school" => $school_id, "deleted" => 0, "status" => 'A']);
$class = $database->select("class", "*", ["school" => $school_id, "deleted" => 0, "status" => 'A']);
$department = $database->select("department", "*", ["school" => $school_id, "deleted" => 0, "status" => 'A']);
$subject = $database->select("subject", "*", ["school" => $school_id, "deleted" => 0, "status" => 'A']);
$regent = $database->select("regent", "*", ["deleted" => 0, "status" => 'A']);
$areas = $database->select("areas", "*", ["school" => $school_id, "deleted" => 0, "status" => 'A']);
$priority_object = $database->select("priority_object", "*", ["school" => $school_id, "deleted" => 0, "status" => 'A']);
$religion = $database->select("religion", "*", ["deleted" => 0, "status" => 'A']);
$ethnic = $database->select("ethnic", "*", ["deleted" => 0, "status" => 'A']);
$nationality = $database->select("nationality", "*", ["deleted" => 0, "status" => 'A']);
$typescore = $database->select("typescore", "*", ["school"        =>$school_id,"deleted" => 0, "status" => 'A']);

$subject = $database->select("subject", "*", ["school" => $school_id, "deleted" => 0, "status" => 'A']);

if ($router['1'] == 'students') {
    $jatbi->permission('students');
    $count = $database->count(
        "students",
        [
            'AND' => [
                "school" => $school_id,
                "deleted" => 0,
            ]
        ]
    );
    $pg = $_GET['pg'];
    if (!$pg)
        $pg = 1;
    $datas = $database->select("students", "*", [
        "AND" => [
            "OR" => [
                'id_student[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'firstname[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'lastname[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'fullname[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'birthday[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'gender[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),

            ],
            'class[<>]' => ($xss->xss($_GET['class']) == '') ?: [$xss->xss($_GET['class']), $xss->xss($_GET['class'])],
            'course[<>]' => ($xss->xss($_GET['course']) == '') ?: [$xss->xss($_GET['course']), $xss->xss($_GET['course'])],
            'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
            "deleted" => 0,
            "school" => $school_id,
        ],
        "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
        "ORDER" => [
            "id" => "DESC",
        ]
    ]);
    $page = $jatbi->pages($count, $setting['site_page'], $pg);
    $templates = $setting['site_backend'] . 'profiles.tpl';
} elseif ($router['1'] == 'students-face-delete') {
    $jatbi->permission('students.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("students", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if (isset($_POST['submit'])) {
                if ($data['face'] == 1) {
                    $curl = curl_init();
                    $array = [
                        "token" => $APIfaceid['token'],
                        "place_active" => $APIfaceid['place'],
                        "emp_id" => $data['active'],
                    ];
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://api.cam.eclo.io/face/delfacebyid',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_POSTFIELDS => json_encode($array),
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    )
                    );
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $getData = json_decode($response, true);
                    if ($getData['status'] == 'success') {
                        $update = [
                            "face" => 0,
                            "avatar" => 'no-images.jpg',
                        ];
                        $database->update("students", $update, ["id" => $data['id']]);
                        echo json_encode(['status' => 'success', 'content' => $getData['content']]);
                    } else {
                        echo json_encode(['status' => 'error', 'content' => $getData['content']]);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'content' => 'Chưa đăng ký face']);
                }
            } else {
                $templates = $setting['site_backend'] . 'profiles.tpl';
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
} elseif ($router['1'] == 'students-face') {
    $jatbi->permission('students.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("students", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if (isset($_POST['token'])) {
                $handle = new Upload($_FILES['avatar']);
                if ($handle->uploaded) {
                    $handle->allowed = array('application/msword', 'image/*');
                    $handle->Process($upload['images']['avatar']['url']);
                    $handle->image_resize = true;
                    $handle->image_ratio_crop = true;
                    $handle->image_y = $upload['images']["avatar"]['thumb_y'];
                    $handle->image_x = $upload['images']["avatar"]['thumb_x'];
                    $handle->allowed = array('application/msword', 'image/*');
                    $handle->Process($upload['images']['avatar']['url'] . 'thumb/');
                }
                if ($handle->processed) {
                    $images = $handle->file_dst_name;
                } else {
                    $error = json_encode(['status' => 'error', 'content' => $handle->error]);
                }
                if (count($error) == 0) {
                    if ($data['face'] == 1) {
                        $api = 'https://api.cam.eclo.io/face/updateface';
                    } elseif ($data['face'] == 0) {
                        $api = 'https://api.cam.eclo.io/face/addface';
                    }
                    $photo = $setting['site_url'] . $upload['images']['avatar']['url'] . $images;
                    $array = [
                        "token" => $APIfaceid['token'],
                        "place_active" => $APIfaceid['place'],
                        "name" => $data['fullname'],
                        "emp_id" => $data['active'],
                        "photo" => $photo,
                        "type" => 0,
                    ];

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $api,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_POSTFIELDS => json_encode($array),
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),

                    )
                    );
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $getData = json_decode($response, true);
                    if ($getData['status'] == 'success') {
                        $update = [
                            "face" => 1,
                            "avatar" => $photo,
                        ];
                        $database->update("students", $update, ["id" => $data['id']]);
                        echo json_encode(['status' => 'success', 'content' => $getData['content'], "data" => $getData, "array" => $array]);
                    } else {
                        echo json_encode(['status' => 'error', 'content' => $getData['content'], "data" => $getData, "array" => $array]);
                    }
                } else {
                    echo $error;
                }
            } else {
                $templates = $setting['site_backend'] . 'profiles.tpl';
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
} elseif ($router['1'] == 'students-add') {
    $jatbi->permission('students.add');
    $ajax = 'true';
    if (isset($_POST['token'])) {
        $handle = new Upload($_FILES['avatar']);
        if ($_POST['token'] != $_SESSION['csrf']['token']) {
            echo json_encode(['status' => 'error', 'content' => $lang['token-khong-dung']]);
        } elseif ($_POST['id_student'] == "" || $_POST['firstname'] == "" || $_POST['lastname'] == "" || $_POST['birthday'] == "" || $_POST['year_of_admission'] == "" || $_POST['gender'] == "" || $_POST['address'] == "" || $_POST['course'] == "") {
            echo json_encode(['status' => 'error', 'content' => $lang['loi-trong'], 'sound' => $setting['site_sound']]);
        }
        if ($_POST['avatar'] == "") {
            $face = 0;
        } else {
            $face = 1;
        }
        if ($handle->uploaded) {
            $handle->allowed = array('application/msword', 'image/*');
            $handle->Process($upload['images']['avatar']['url']);
        }

        if ($handle->processed && $_POST['id_student'] && $_POST['firstname'] && $_POST['lastname'] && $_POST['birthday'] && $_POST['year_of_admission'] && $_POST['gender'] && $_POST['address']) {
            $img = $setting['site_url'] . $upload['images']['avatar']['url'] . $handle->file_dst_name;
            $insert = [
                "id_student" => $xss->xss($_POST['id_student']),
                "firstname" => $xss->xss($_POST['firstname']),
                "lastname" => $xss->xss($_POST['lastname']),
                "fullname" => $xss->xss($_POST['firstname']) . ' ' . $xss->xss($_POST['lastname']),
                "birthday" => date('Y-m-d', strtotime(str_replace('/', '-', $_POST['birthday']))),
                "year_of_admission" => date('Y-m-d H:i:s'),
                "course" => $xss->xss($_POST['course']),
                "gender" => $xss->xss($_POST['gender']),
                "address" => $xss->xss($_POST['address']),
                "province" => $xss->xss($_POST['province']),
                "district" => $xss->xss($_POST['district']),
                "ward" => $xss->xss($_POST['ward']),
                "parent" => $xss->xss($_POST['parent']),
                "avatar" => $img,
                "face" => $face,
                "active" => $jatbi->active(32),
                "priority_object" => $xss->xss($_POST['priority_object']),
                "health_insurance_id" => $xss->xss($_POST['health_insurance_id']),
                "body_insurance_id" => $xss->xss($_POST['body_insurance_id']),
                "nationality" => $xss->xss($_POST['nationality']),
                "ethnic" => $xss->xss($_POST['ethnic']),
                "religion" => $xss->xss($_POST['religion']),
                "hobby" => $xss->xss($_POST['hobby']),
                "allergy" => $xss->xss($_POST['allergy']),
                "status" => $xss->xss($_POST['status']),
                "school" => $school_id,
            ];
            $database->insert("students", $insert);
            $jatbi->logs('students', 'add', $insert);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
        }
    } else {
        $templates = $setting['site_backend'] . 'profiles.tpl';
    }
} elseif ($router['1'] == 'students-edit') {
    $jatbi->permission('students.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("students", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if (isset($_POST['token'])) {
                $partten = "/^[A-Za-z0-9_\.]{" . $setting['site_characters'] . ",32}$/";


                $handle = new Upload($_FILES['avatar']);
                if ($_POST['token'] != $_SESSION['csrf']['token']) {
                    echo json_encode(['status' => 'error', 'content' => $lang['token-khong-dung']]);
                } elseif ($_POST['id_student'] == "" || $_POST['firstname'] == "" || $_POST['lastname'] == "" || $_POST['birthday'] == "" || $_POST['year_of_admission'] == "" || $_POST['gender'] == "" || $_POST['address'] == "" || $_POST['course'] == "") {
                    echo json_encode(['status' => 'error', 'content' => $lang['loi-trong'], 'sound' => $setting['site_sound']]);
                }



                if ($handle->uploaded) {
                    $handle->allowed = array('application/msword', 'image/*');
                    $handle->Process($upload['images']['avatar']['url']);
                }
                if ($handle->processed && $_POST['id_student'] && $_POST['firstname'] && $_POST['lastname'] && $_POST['birthday'] && $_POST['year_of_admission'] && $_POST['gender'] && $_POST['address']) {
                    $img = $setting['site_url'] . $upload['images']['avatar']['url'] . $handle->file_dst_name;
                    $insert = [
                        "id_student" => $xss->xss($_POST['id_student']),
                        "firstname" => $xss->xss($_POST['firstname']),
                        "lastname" => $xss->xss($_POST['lastname']),
                        "fullname" => $xss->xss($_POST['firstname']) . ' ' . $xss->xss($_POST['lastname']),
                        "birthday" => date('Y-m-d', strtotime(str_replace('/', '-', $_POST['birthday']))),
                        "year_of_admission" => $xss->xss($_POST['year_of_admission']),
                        "course" => $xss->xss($_POST['course']),
                        "gender" => $xss->xss($_POST['gender']),
                        "address" => $xss->xss($_POST['address']),
                        "province" => $xss->xss($_POST['province']),
                        "district" => $xss->xss($_POST['district']),
                        "ward" => $xss->xss($_POST['ward']),
                        "parent" => $xss->xss($_POST['parent']),
                        // "avatar"        => $img,
                        "priority_object" => $xss->xss($_POST['priority_object']),
                        "health_insurance_id" => $xss->xss($_POST['health_insurance_id']),
                        "body_insurance_id" => $xss->xss($_POST['body_insurance_id']),
                        "nationality" => $xss->xss($_POST['nationality']),
                        "ethnic" => $xss->xss($_POST['ethnic']),
                        "religion" => $xss->xss($_POST['religion']),
                        "hobby" => $xss->xss($_POST['hobby']),
                        "allergy" => $xss->xss($_POST['allergy']),
                        "status" => $xss->xss($_POST['status']),
                        "school" => $school_id,
                    ];
                    $database->update("students", $insert, ["id" => $data['id']]);
                    $jatbi->logs('students', 'edit', $insert);
                    echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
                }
            } else {
                $templates = $setting['site_backend'] . 'profiles.tpl';
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
} elseif ($router['1'] == 'students-delete') {
    $jatbi->permission('students.delete');
    $ajax = 'true';
    if ($router['2']) {
        $datas = $database->select("students", "*", ["id" => explode(',', $xss->xss($router['2']))]);
        if (isset($_POST['submit'])) {
            $jatbi->logs('students', 'delete', $datas);
            $database->update("students", ["deleted" => 1,], ["id" => explode(',', $xss->xss($router['2']))]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
        } else {
            $templates = $setting['site_backend'] . 'profiles.tpl';
        }
    } else {
        header("HTTP/1.0 404 Not Found");
        die();
    }
} elseif ($router['1'] == 'students-status') {
    $jatbi->permission('students.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("students", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if ($data['status'] === 'A') {
                $status = "D";
            } elseif ($data['status'] === 'D') {
                $status = "A";
            }
            $database->update("students", ["status" => $status], ["id" => $data['id']]);
            $jatbi->logs('students', 'status', ["data" => $data, "status" => $status]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-trang-thai'], 'sound' => $setting['site_sound']]);
        } else {
            echo json_encode(['status' => 'error', 'content' => $lang['cap-nhat-that-bai'],]);
        }
    }
} elseif ($router['1'] == 'parents') {
    $jatbi->permission('parents');

    foreach ($school_parents as $school) {
        $count = $database->count(
            "parent",
            [
                "AND" => [
                    "OR" => [
                        'phone_number[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                        'name[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),

                        'birthday[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                        'address[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                    ],
                    'province[<>]' => ($xss->xss($_GET['province']) == '') ?: [$xss->xss($_GET['province']), $xss->xss($_GET['province'])],
                    'district[<>]' => ($xss->xss($_GET['district']) == '') ?: [$xss->xss($_GET['district']), $xss->xss($_GET['district'])],
                    'ward[<>]' => ($xss->xss($_GET['ward']) == '') ?: [$xss->xss($_GET['ward']), $xss->xss($_GET['ward'])],
                    'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
                    "deleted" => 0,
                    "id" => $school["parent"],
                ]
            ]
        );

        $pg = $_GET['pg'];
        if (!$pg)
            $pg = 1;
        $datas[] = $database->get("parent", "*", [
            "AND" => [
                "OR" => [
                    'phone_number[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                    'name[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),

                    'birthday[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                    'address[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                ],
                'province[<>]' => ($xss->xss($_GET['province']) == '') ?: [$xss->xss($_GET['province']), $xss->xss($_GET['province'])],
                'district[<>]' => ($xss->xss($_GET['district']) == '') ?: [$xss->xss($_GET['district']), $xss->xss($_GET['district'])],
                'ward[<>]' => ($xss->xss($_GET['ward']) == '') ?: [$xss->xss($_GET['ward']), $xss->xss($_GET['ward'])],
                'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
                "deleted" => 0,
                "id" => $school["parent"],
            ],
            "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
            "ORDER" => [
                "id" => "DESC",
            ]
        ]);
    }

    $page = $jatbi->pages($count, $setting['site_page'], $pg);
    $templates = $setting['site_backend'] . 'profiles.tpl';
} elseif ($router['1'] == 'parents-face') {
    $jatbi->permission('parents.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("parent", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if (isset($_POST['token'])) {
                $handle = new Upload($_FILES['avatar']);
                if ($handle->uploaded) {
                    $handle->allowed = array('application/msword', 'image/*');
                    $handle->Process($upload['images']['avatar']['url']);
                    $handle->image_resize = true;
                    $handle->image_ratio_crop = true;
                    $handle->image_y = $upload['images']["avatar"]['thumb_y'];
                    $handle->image_x = $upload['images']["avatar"]['thumb_x'];
                    $handle->allowed = array('application/msword', 'image/*');
                    $handle->Process($upload['images']['avatar']['url'] . 'thumb/');
                }
                if ($handle->processed) {
                    $images = $handle->file_dst_name;
                } else {
                    $error = json_encode(['status' => 'error', 'content' => $handle->error]);
                }
                if (count($error) == 0) {
                    if ($data['face'] == 1) {
                        $api = 'https://api.cam.eclo.io/face/updateface';
                    } elseif ($data['face'] == 0) {
                        $api = 'https://api.cam.eclo.io/face/addface';
                    }
                    $photo = $setting['site_url'] . $upload['images']['avatar']['url'] . $images;
                    $array = [
                        "token" => $APIfaceid['token'],
                        "place_active" => $APIfaceid['place'],
                        "name" => $data['name'],
                        "emp_id" => $data['active'],
                        "photo" => $photo,
                        "type" => 3,
                    ];

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $api,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_POSTFIELDS => json_encode($array),
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),

                    )
                    );
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $getData = json_decode($response, true);
                    if ($getData['status'] == 'success') {
                        $update = [
                            "face" => 1,
                            "avatar" => $photo,
                        ];
                        $database->update("parent", $update, ["id" => $data['id']]);
                        echo json_encode(['status' => 'success', 'content' => $getData['content'], "data" => $getData, "array" => $array]);
                    } else {
                        echo json_encode(['status' => 'error', 'content' => $getData['content'], "data" => $getData, "array" => $array]);
                    }
                } else {
                    echo $error;
                }
            } else {
                $templates = $setting['site_backend'] . 'profiles.tpl';
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
} elseif ($router['1'] == 'parents-face-delete') {
    $jatbi->permission('parents.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("parent", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if (isset($_POST['submit'])) {
                if ($data['face'] == 1) {
                    $curl = curl_init();
                    $array = [
                        "token" => $APIfaceid['token'],
                        "place_active" => $APIfaceid['place'],
                        "emp_id" => $data['active'],
                    ];
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://api.cam.eclo.io/face/delfacebyid',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_POSTFIELDS => json_encode($array),
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    )
                    );
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $getData = json_decode($response, true);
                    if ($getData['status'] == 'success') {
                        $update = [
                            "face" => 0,
                            "avatar" => 'no-images.jpg',
                        ];
                        $database->update("parent", $update, ["id" => $data['id']]);
                        echo json_encode(['status' => 'success', 'content' => $getData['content']]);
                    } else {
                        echo json_encode(['status' => 'error', 'content' => $getData['content']]);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'content' => 'Chưa đăng ký face']);
                }
            } else {
                $templates = $setting['site_backend'] . 'profiles.tpl';
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
} elseif ($router['1'] == 'parents-add') {
    $jatbi->permission('parents.add');
    $ajax = 'true';
    if (isset($_POST['token'])) {
        $handle = new Upload($_FILES['avatar']);
        $count = $database->count(
            "parent",
            [
                'AND' => [
                    "phone_number" => $xss->xss($_POST['phone_number']),
                    "status" => 'A',
                    "deleted" => 0,
                ]
            ]
        );
        $parentss = $database->get(
            "parent",
            "id",
            [
                'AND' => [
                    "phone_number" => $_POST['phone_number'],
                    "status" => 'A',
                    "deleted" => 0,
                ]
            ]
        );
        $count_active = $database->count(
            "school_parent",
            [
                'AND' => [
                    "parent" => $parentss,
                    'school' => $school_id,
                    "status" => 'A',
                    "deleted" => 0,
                ]
            ]
        );
        if ($_POST['token'] != $_SESSION['csrf']['token']) {
            echo json_encode(['status' => 'error', 'content' => $lang['token-khong-dung']]);
        } elseif ($_POST['phone_number'] == "" || $_POST['password'] == "" || $_POST['name'] == "" || $_POST['birthday'] == "" || $_POST['type'] == "" || $_POST['address'] == "" || $_POST['province'] == "" || $_POST['district'] == "" || $_POST['ward'] == "") {
            echo json_encode(['status' => 'error', 'content' => $lang['loi-trong'], 'sound' => $setting['site_sound']]);
        }
        if ($handle->uploaded) {
            $handle->allowed = array('application/msword', 'image/*');
            $handle->Process($upload['images']['avatar']['url']);
        }
        if ($_POST['avatar'] == "") {
            $face = 0;
        } else {
            $face = 1;
        }
        if ($count > 0) {
            if ($count_active == 0) {
                $insert_register = [
                    "parent" => $parentss,
                    "school" => $school_id,
                    "status" => 'A',
                ];
                $database->insert("school_parent", $insert_register);
                $jatbi->logs('school_parent', 'add', $insert_register);
                echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);

            } else {
                echo json_encode(['status' => 'error', 'content' => $lang['tai-khoan-da-dang-ki'], 'sound' => $setting['site_sound']]);
            }
        } elseif ($count == 0 && $count_active == 0) {
            if ($handle->processed && $_POST['phone_number'] && $_POST['name'] && $_POST['birthday'] && $_POST['type'] && $_POST['address'] && $_POST['province'] && $_POST['district'] && $_POST['ward']) {
                $img = $setting['site_url'] . $upload['images']['avatar']['url'] . $handle->file_dst_name;
                $insert = [
                    "phone_number" => $xss->xss($_POST['phone_number']),
                    "password" => password_hash($xss->xss($_POST['password']), PASSWORD_DEFAULT),
                    "name" => $xss->xss($_POST['name']),
                    "birthday" => $xss->xss($_POST['birthday']),
                    "citizenId" => $xss->xss($_POST['citizenId']),
                    "type" => $xss->xss($_POST['type']),
                    "address" => $xss->xss($_POST['address']),
                    "province" => $xss->xss($_POST['province']),
                    "district" => $xss->xss($_POST['district']),
                    "ward" => $xss->xss($_POST['ward']),
                    "avatar" => $img,
                    "face" => $face,
                    "active" => $jatbi->active(32),
                    "status" => $xss->xss($_POST['status']),
                ];
                $database->insert("parent", $insert);
                $tui = $database->id();
                $insert_register = [
                    "parent" => $tui,
                    "school" => $school_id,
                    "status" => 'A',
                ];
                $database->insert("school_parent", $insert_register);
                $jatbi->logs('parent', 'add', $insert);
                $jatbi->logs('school_parent', 'add', $insert_register);
                echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
            }
        }
    } else {
        $templates = $setting['site_backend'] . 'profiles.tpl';
    }

} elseif ($router['1'] == 'parents-edit') {
    $jatbi->permission('parents.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("parent", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if (isset($_POST['token'])) {
                $partten = "/^[A-Za-z0-9_\.]{" . $setting['site_characters'] . ",32}$/";
                $handle = new Upload($_FILES['avatar']);
                if ($_POST['token'] != $_SESSION['csrf']['token']) {
                    echo json_encode(['status' => 'error', 'content' => $lang['token-khong-dung']]);
                } elseif ($_POST['phone_number'] == "" || $_POST['password'] == "" || $_POST['name'] == "" || $_POST['birthday'] == "" || $_POST['type'] == "" || $_POST['address'] == "" || $_POST['province'] == "" || $_POST['district'] == "" || $_POST['ward'] == "") {
                    echo json_encode(['status' => 'error', 'content' => $lang['loi-trong'], 'sound' => $setting['site_sound']]);
                }
                if ($handle->uploaded) {
                    $handle->allowed = array('application/msword', 'image/*');
                    $handle->Process($upload['images']['avatar']['url']);
                }
                if ($_POST['avatar'] == "") {
                    $face = 0;
                } else {
                    $face = 1;
                }
                if ($handle->processed && $_POST['phone_number'] && $_POST['password'] && $_POST['name'] && $_POST['birthday'] && $_POST['type'] && $_POST['address'] && $_POST['province'] && $_POST['district'] && $_POST['ward']) {
                    $img = $setting['site_url'] . $upload['images']['avatar']['url'] . $handle->file_dst_name;
                    $insert = [
                        "phone_number" => $xss->xss($_POST['phone_number']),
                        "password" => password_hash($xss->xss($_POST['password']), PASSWORD_DEFAULT),
                        "name" => $xss->xss($_POST['name']),
                        "birthday" => $xss->xss($_POST['birthday']),
                        "citizenId" => $xss->xss($_POST['citizenId']),
                        "type" => $xss->xss($_POST['type']),
                        "address" => $xss->xss($_POST['address']),
                        "province" => $xss->xss($_POST['province']),
                        "district" => $xss->xss($_POST['district']),
                        "ward" => $xss->xss($_POST['ward']),
                        "avatar" => $img,
                        "face" => $face,
                        "active" => $jatbi->active(32),
                        "status" => $xss->xss($_POST['status']),
                    ];
                    $database->update("parent", $insert, ["id" => $data['id']]);

                    $jatbi->logs('parent', 'add', $insert);

                    echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
                }

            } else {
                $templates = $setting['site_backend'] . 'profiles.tpl';
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
} elseif ($router['1'] == 'parents-delete') {
    $jatbi->permission('parents.delete');
    $ajax = 'true';
    if ($router['2']) {
        $datas = $database->select("parent", "*", ["id" => explode(',', $xss->xss($router['2']))]);
        if (isset($_POST['submit'])) {
            $jatbi->logs('parent', 'delete', $datas);
            $database->update("parent", ["deleted" => 1,], ["id" => explode(',', $xss->xss($router['2']))]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
        } else {
            $templates = $setting['site_backend'] . 'profiles.tpl';
        }
    } else {
        header("HTTP/1.0 404 Not Found");
        die();
    }
} elseif ($router['1'] == 'parents-status') {
    $jatbi->permission('parents.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("parent", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if ($data['status'] === 'A') {
                $status = "D";
            } elseif ($data['status'] === 'D') {
                $status = "A";
            }
            $database->update("parent", ["status" => $status], ["id" => $data['id']]);
            $jatbi->logs('parent', 'status', ["data" => $data, "status" => $status]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-trang-thai'], 'sound' => $setting['site_sound']]);
        } else {
            echo json_encode(['status' => 'error', 'content' => $lang['cap-nhat-that-bai'],]);
        }
    }
} elseif ($router['1'] == 'birthday') {
    $jatbi->permission('birthday');
    $count = $database->count(
        "students",
        [
            'AND' => [
                "deleted" => 0,
                "school" => $school_id,
            ]
        ]
    );
    $pg = $_GET['pg'];
    if (!$pg)
        $pg = 1;
    $datas = $database->select("students", "*", [
        "AND" => [
            "OR" => [
                'id_student[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'firstname[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'lastname[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'birthday[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),

            ],
            'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
            "deleted" => 0,
            "school" => $school_id,
        ],
        "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
        "ORDER" => [
            "id" => "DESC",
        ]
    ]);
    $page = $jatbi->pages($count, $setting['site_page'], $pg);
    $templates = $setting['site_backend'] . 'profiles.tpl';
} elseif ($router['1'] == 'timekeeping') {
    if ($router['2']) {
        $jatbi->permission('timekeeping');
        $year = $xss->xss($_GET['year']) == '' ? date("Y") : $xss->xss($_GET['year']);
        $month = $xss->xss($_GET['month']) == '' ? date("m") : $xss->xss($_GET['month']);
        $date_form = date("t", strtotime($year . "-" . $month . "-01"));
        $_SESSION['router'] = $router['2'];
        for ($day = 1; $day <= $date_form; $day++) {
            if ($day < 10) {
                $day = '0' . $day;
            }
            $date = date("Y-m-d", strtotime($year . "-" . $month . "-" . $day));
            $week = date("N", strtotime($date));
            $dates[] = [
                "name" => $day,
                "date" => $date,
                "week" => $week,
            ];
        }
        $class = $database->select("class_diagram", "*", [
            "id" => $xss->xss($router['2']),
            "deleted" => 0,
            "status" => 'A'
        ]);
        foreach ($class as $key => $class) {
            $SelectPer[$class['id']] = $database->select("arrange_class", "*", [
                // 'id[<>]' => ($xss->xss($_GET['students']) == '') ?: [$xss->xss($_GET['students']), $xss->xss($_GET['students'])],
                "class_diagram" => $xss->xss($router['2']),
                "deleted" => 0,
                "status" => 'A',
                "school" => $school_id,
            ]);
            $datas[$key] = [
                "name" => $database->get("class", "name", ["id" => $class['class']]),
            ];
            foreach ($SelectPer[$class['id']] as $per) {
                $datas[$key]["students"][$per['id']] = [
                    "id_arr" => $per['id'],
                    "id" => $database->get("students", "id", ["id" => $per['students']]),
                    "firstname" => $database->get("students", "firstname", ["id" => $per['students']]),
                    "lastname" => $database->get("students", "lastname", ["id" => $per['students']]),
                ];
                foreach ($dates as $date) {
                    if (strtotime($date['date']) >= strtotime($datas[$key]["students"][$per['id']]['contract'])) {
                        $datas[$key]["students"][$per['id']]["roster"] = $database->get("rosters", "timework", [
                            "arrange_class" => $per['id'],
                            "school" => $school_id,
                            "date[<=]" => $date['date'],
                            "deleted" => 0,
                            "ORDER" => ["id" => "DESC"]
                        ]);
                        $checked[$per['id']] = $database->get("timekeeping", ["checkin", "checkout"], [
                            "arrange_class" => $per['id'],
                            "date" => date("Y-m-d", strtotime($date['date'])),
                            "school" => $school_id,
                        ]);
                        $timework_details[$per['id']] = $database->get("timework_details", "*", [
                            "week" => $date['week'],
                            "timework" => $datas[$key]["students"][$per['id']]['roster'],
                            "school" => $school_id,
                        ]);
                        $furloughs[$per['id']] = $database->get("furlough", "id", [
                            "arrange_class" => $per['id'],
                            "date_start[<=]" => $date['date'],
                            "date_end[>=]" => $date['date'],
                            "deleted" => 0,
                            "statu" => "D",
                            "status" => "A",
                            "school" => $school_id,
                        ]);
                        if ($timework_details[$per['id']]['off'] == 1) {
                            $off[$per['id']] = 1;
                            $offcontent[$per['id']] = 'OFF';
                            $color[$per['id']] = 'bg-primary bg-opacity-10';
                        } else {
                            $off[$per['id']] = 0;
                            if ($checked[$per['id']]['checkin'] != '' && $checked[$per['id']]['checkout'] == '') {
                                $color[$per['id']] = 'bg-danger bg-opacity-10';
                            } elseif ($checked[$per['id']]['checkin'] == '' && $checked[$per['id']]['checkout'] == '') {
                                if (strtotime($date['date'] . ' ' . $setting['timework_to']) <= strtotime(date("Y-m-d H:i:s"))) {
                                    $color[$per['id']] = 'bg-warning bg-opacity-10';
                                } else {
                                    $color[$per['id']] = 'bg-light bg-opacity-10';
                                }
                            } else {
                                $color[$per['id']] = 'bg-success bg-opacity-10';
                            }
                        }
                        if ($furloughs[$per['id']] > 0) {
                            $off[$per['id']] = 1;
                            $offcontent[$per['id']] = $database->get("furlough_categorys", "code", ["deleted" => 0, "id" => $furloughs[$per['id']]]);
                            $color[$per['id']] = 'bg-primary bg-opacity-25';
                            if ($furloughs[$per['id']]['numberday'] == 4) {
                                $furlough[$per['id']][$furloughs[$per['id']]['furlough']] = [
                                    "id" => $furloughs[$per['id']],
                                    "content" => $offcontent[$per['id']],
                                ];
                            }
                            if ($furloughs[$per['id']]['numberday'] == 5) {
                                $furlough[$per['id']][$furloughs[$per['id']]['furlough']] = [
                                    "id" => $furloughs[$per['id']],
                                    "content" => $offcontent[$per['id']],
                                ];
                            }
                        }
                        $datas[$key]["students"][$per['id']]["dates"][$date['date']] = [
                            "id_arr" => $per['id'],
                            "id" => $database->get("students", "id", ["id" => $per['students']]),
                            "firstname" => $database->get("students", "firstname", ["id" => $per['students']]),
                            "lastname" => $database->get("students", "lastname", ["id" => $per['students']]),
                            "date" => $date['date'],
                            "week" => $date['week'],
                            "color" => $color[$per['id']],
                            "checkin" => [
                                "time" => $checked[$per['id']]['checkin'],
                            ],
                            "checkout" => [
                                "time" => $checked[$per['id']]['checkout'],
                            ],
                            "off" => [
                                "status" => $off[$per['id']],
                                "content" => $offcontent[$per['id']],
                            ],
                        ];
                    } else {
                        $datas[$key]["students"][$per['id']]["dates"][$date['date']] = [
                            "firstname" => $database->get("students", "firstname", ["id" => $per['students']]),
                            "lastname" => $database->get("students", "lastname", ["id" => $per['students']]),
                            "date" => $date['date'],
                            "week" => $date['week'],
                            "status" => '',
                            "color" => "bg-secondary bg-opacity-25",
                        ];
                    }
                }
            }
        }
        $templates = $setting['site_backend'] . 'profiles.tpl';
    }
} elseif ($router['1'] == 'timekeeping-add') {
    $jatbi->permission('timekeeping.add');
    $ajax = 'true';
    $arrange_class = $database->select("arrange_class", "*", [
        "class_diagram" => $_SESSION['router'],
        "school" => $school_id,
        "deleted" => 0,
        "status" => 'A'
    ]);
    if (isset($_POST['token'])) {

        $class = $database->get("class", "*", [
            "id" => $xss->xss($router['2']),
            "deleted" => 0,
            "status" => 'A'
        ]);

        if ($_POST['arrange_class'] == "" || $_POST['date'] == "" || $_POST['status'] == "") {
            echo json_encode(['status' => 'error', 'content' => $lang['loi-trong']]);
        }
        if ($_POST['arrange_class'] && $_POST['date'] && $_POST['status']) {
            $gettime = $database->get("timekeeping", "*", [
                "arrange_class" => $xss->xss($_POST['arrange_class']),
                "date" => date("Y-m-d", strtotime($_POST['date'])),
            ]);
            if ($_POST['status'] == 1) {
                $timekeeping = [
                    "arrange_class" => $xss->xss($_POST['arrange_class']),
                    "date" => $xss->xss(date("Y-m-d", strtotime($_POST['date']))),
                    "checkin" => $xss->xss(date("H:i:s", strtotime($_POST['date']))),
                    "date_poster" => date("Y-m-d H:i:s"),
                    "school" => $school_id,
                ];
            }
            if ($_POST['status'] == 2) {
                $timekeeping = [
                    "arrange_class" => $xss->xss($_POST['arrange_class']),
                    "date" => $xss->xss(date("Y-m-d", strtotime($_POST['date']))),
                    "checkout" => $xss->xss(date("H:i:s", strtotime($_POST['date']))),
                    "date_poster" => date("Y-m-d H:i:s"),
                    "school" => $school_id,
                ];
            }
            if ($gettime > 1) {
                $database->update("timekeeping", $timekeeping, ["id" => $gettime['id']]);
                $getID = $gettime['id'];
                $arrange_student = $database->get("arrange_class", "students", ["id" => $xss->xss($_POST['arrange_class'])]);
                $device = $database->select("device_parent", "device_id", [
                    "parent" => $database->get("students", "parent", ["id" => $arrange_student]),
                    "school" => $school,
                    "deleted" => 0,
                    "status" => 'A'
                ]);
                function sendNotification($title, $message, $device)
                {
                    $content = array(
                        "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                    );

                    $fields = [
                        'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6',
                        // ID ứng dụng OneSignal của bạn
                        'include_player_ids' => $device,
                        // Danh sách các device token
                        'contents' => $content,
                        'headings' => array("en" => $title) // Tiêu đề thông báo
                    ];

                    $fields = json_encode($fields);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json; charset=utf-8',
                        'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                    )
                    );
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    $result = curl_exec($ch);

                    if ($result === FALSE) {
                        die('Curl failed: ' . curl_error($ch));
                    }

                    curl_close($ch);

                    return $result;
                }

                // Gọi hàm sendNotification để gửi thông báo đẩy

                $title = "Hệ thống nhận diện " . $database->get('school', 'name', ['id' => $school]);
                $message = $database->get("students", "fullname", ["id" => $arrange_student]) . ' đã nhận diện lúc ' . $xss->xss(date("H:i:s d-m-Y", strtotime($_POST['date'])));
                $result = sendNotification($title, $message, $device);
            } else {
                $database->insert("timekeeping", $timekeeping);
                $getID = $database->id();
                $arrange_student = $database->get("arrange_class", "students", ["id" => $xss->xss($_POST['arrange_class'])]);
                $device = $database->select("device_parent", "device_id", [
                    "parent" => $database->get("students", "parent", ["id" => $arrange_student]),
                    "school" => $school,
                    "deleted" => 0,
                    "status" => 'A'
                ]);
                function sendNotification($title, $message, $device)
                {
                    $content = array(
                        "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                    );

                    $fields = [
                        'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6',
                        // ID ứng dụng OneSignal của bạn
                        'include_player_ids' => $device,
                        // Danh sách các device token
                        'contents' => $content,
                        'headings' => array("en" => $title) // Tiêu đề thông báo
                    ];

                    $fields = json_encode($fields);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json; charset=utf-8',
                        'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                    )
                    );
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    $result = curl_exec($ch);

                    if ($result === FALSE) {
                        die('Curl failed: ' . curl_error($ch));
                    }

                    curl_close($ch);

                    return $result;
                }

                // Gọi hàm sendNotification để gửi thông báo đẩy

                $title = "Hệ thống nhận diện " . $database->get('school', 'name', ['id' => $school]);
                $message = $database->get("students", "fullname", ["id" => $arrange_student]) . ' đã nhận diện lúc ' . $xss->xss(date("H:i:s d-m-Y", strtotime($_POST['date'])));
                $result = sendNotification($title, $message, $device);
            }
            $insert = [
                "arrange_class" => $xss->xss($_POST['arrange_class']),
                "notes" => $xss->xss($_POST['notes']),
                "date" => $xss->xss($_POST['date']),
                "status" => $xss->xss($_POST['status']),
                "accounts" => $account['id'],
                "date_poster" => date("Y-m-d H:i:s"),
                "school" => $school_id,
            ];
            $database->insert("timekeeping_details", $insert);

            $jatbi->logs('timekeeping_details', 'add', [$insert, $timeLate]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
        }
    } else {
        $templates = $setting['site_backend'] . 'profiles.tpl';
    }
} elseif ($router['1'] == 'timekeeping-views') {
    $jatbi->permission('timekeeping.edit');
    $ajax = 'true';
    if ($router['2']) {
        $per = $database->get("arrange_class", "*", ["school" => $school_id, "id" => $xss->xss($router['2'])]);
        $students = $database->get("students", "*", ['id' => $per['students']]);
        if ($per > 1) {
            $datas = $database->select("timekeeping_details", "*", [
                "arrange_class" => $router['2'],
                "date[<>]" => [date("Y-m-d 00:00:00", strtotime($router['3'])), date("Y-m-d 23:59:59", strtotime($router['3']))],
                "school" => $school_id,
                "deleted" => 0,
            ]);
            $templates = $setting['site_backend'] . 'profiles.tpl';
        } else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
} elseif ($router['1'] == 'timekeeping-delete') {
    $jatbi->permission('timekeeping.delete');
    $ajax = 'true';
    if ($router['2']) {
        $datas = $database->select("timekeeping", "*", ["id" => explode(',', $xss->xss($router['2']))]);
        $jatbi->logs('timekeeping', 'delete', $datas);
        $database->update("timekeeping", ["deleted" => 1,], ["id" => explode(',', $xss->xss($router['2']))]);
        echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
    }
} elseif ($router['1'] == 'timekeeping-class') {
    $jatbi->permission('class');
    $count = $database->count(
        "class_diagram",
        [
            'AND' => [
                "school" => $school_id,
                "deleted" => 0,
            ]
        ]
    );
    $date = date("Y-m-d");
    $course = $database->select("course", "*", [
        "school" => $school_id,
        "status" => 'A',
        "deleted" => 0,
    ]);
    $pg = $_GET['pg'];
    if (!$pg)
        $pg = 1;
    foreach ($course as $value) {
        $date_timestamp = strtotime($date);
        $start_timestamp = strtotime($value['startdate']);
        $end_timestamp = strtotime($value['enddate']);

        if ($date_timestamp >= $start_timestamp && $date_timestamp <= $end_timestamp) {
            $datas = $database->select("class_diagram", "*", [
                "AND" => [
                    'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
                    "deleted" => 0,
                    'course' => $value['id'],
                    "school" => $school_id,
                ],
                "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
                "ORDER" => [
                    "id" => "DESC",
                ]
            ]);
        }


    }

    $page = $jatbi->pages($count, $setting['site_page'], $pg);
    $templates = $setting['site_backend'] . 'profiles.tpl';
} elseif ($router['1'] == 'health') {
    $jatbi->permission('health');
    $count = $database->count(
        "health",
        [
            'AND' => [
                "deleted" => 0,
            ]
        ]
    );
    $pg = $_GET['pg'];
    if (!$pg)
        $pg = 1;
    $datas = $database->select("health", "*", [
        "AND" => [
            "OR" => [

                'date[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'heartbeat[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'blood_pressure[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'temperature[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'weight[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'height[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'prehistoric[~]' => ($xss->xss($_GET['prehistoric']) == '') ? '%' : $xss->xss($_GET['prehistoric']),
            ],
            'students[<>]' => ($xss->xss($_GET['students']) == '') ?: [$xss->xss($_GET['students']), $xss->xss($_GET['students'])],
            'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
            "deleted" => 0,
            "school" => $school_id,
        ],
        "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
        "ORDER" => [
            "id" => "DESC",
        ]
    ]);
    $page = $jatbi->pages($count, $setting['site_page'], $pg);
    $templates = $setting['site_backend'] . 'profiles.tpl';
} elseif ($router['1'] == 'health-add') {
    $jatbi->permission('health.add');
    $ajax = 'true';
    if (isset($_POST['token'])) {
        $handle = new Upload($_FILES['avatar']);
        if ($_POST['token'] != $_SESSION['csrf']['token']) {
            echo json_encode(['status' => 'error', 'content' => $lang['token-khong-dung']]);
        } elseif ($_POST['heartbeat'] == "" || $_POST['blood_pressure'] == "" || $_POST['temperature'] == "" || $_POST['weight'] == "" || $_POST['height'] == "" || $_POST['students'] == "" || $_POST['date'] == "") {
            echo json_encode(['status' => 'error', 'content' => $lang['loi-trong'], 'sound' => $setting['site_sound']]);
        }

        if ($handle->processed && $_POST['heartbeat'] && $_POST['blood_pressure'] && $_POST['temperature'] && $_POST['weight'] && $_POST['height'] && $_POST['students'] && $_POST['date']) {
            $insert = [
                "date" => date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date']))),
                "heartbeat" => $xss->xss($_POST['heartbeat']),
                "blood_pressure" => $xss->xss($_POST['blood_pressure']),
                "temperature" => $xss->xss($_POST['temperature']),
                "weight" => $xss->xss($_POST['weight']),
                "height" => $xss->xss($_POST['height']),
                "prehistoric" => $xss->xss($_POST['prehistoric']),
                "students" => $xss->xss($_POST['students']),
                "status" => $xss->xss($_POST['status']),
                "school" => $school_id,
            ];
            $database->insert("health", $insert);
            $jatbi->logs('health', 'add', $insert);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
        }
    } else {
        $templates = $setting['site_backend'] . 'profiles.tpl';
    }
} elseif ($router['1'] == 'health-edit') {
    $jatbi->permission('health.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("health", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if (isset($_POST['token'])) {
                $partten = "/^[A-Za-z0-9_\.]{" . $setting['site_characters'] . ",32}$/";

                $handle = new Upload($_FILES['avatar']);
                if ($_POST['token'] != $_SESSION['csrf']['token']) {
                    echo json_encode(['status' => 'error', 'content' => $lang['token-khong-dung']]);
                } elseif ($_POST['heartbeat'] == "" || $_POST['blood_pressure'] == "" || $_POST['temperature'] == "" || $_POST['weight'] == "" || $_POST['height'] == "" || $_POST['students'] == "" || $_POST['date'] == "") {
                    echo json_encode(['status' => 'error', 'content' => $lang['loi-trong'], 'sound' => $setting['site_sound']]);
                }

                if ($handle->processed && $_POST['heartbeat'] && $_POST['blood_pressure'] && $_POST['temperature'] && $_POST['weight'] && $_POST['height'] && $_POST['students'] && $_POST['date']) {
                    $insert = [
                        "date" => date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date']))),
                        "heartbeat" => $xss->xss($_POST['heartbeat']),
                        "blood_pressure" => $xss->xss($_POST['blood_pressure']),
                        "temperature" => $xss->xss($_POST['temperature']),
                        "weight" => $xss->xss($_POST['weight']),
                        "height" => $xss->xss($_POST['height']),
                        "prehistoric" => $xss->xss($_POST['prehistoric']),
                        "students" => $xss->xss($_POST['students']),
                        "status" => $xss->xss($_POST['status']),
                        "school" => $school_id,
                    ];
                    $database->update("health", $insert, ["id" => $data['id']]);
                    $jatbi->logs('health', 'edit', $insert);
                    echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
                }
            } else {
                $templates = $setting['site_backend'] . 'profiles.tpl';
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
} elseif ($router['1'] == 'health-delete') {
    $jatbi->permission('health.delete');
    $ajax = 'true';
    if ($router['2']) {
        $datas = $database->select("health", "*", ["id" => explode(',', $xss->xss($router['2']))]);
        if (isset($_POST['submit'])) {
            $jatbi->logs('health', 'delete', $datas);
            $database->update("health", ["deleted" => 1,], ["id" => explode(',', $xss->xss($router['2']))]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
        } else {
            $templates = $setting['site_backend'] . 'profiles.tpl';
        }
    } else {
        header("HTTP/1.0 404 Not Found");
        die();
    }
} elseif ($router['1'] == 'health-status') {
    $jatbi->permission('health.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("health", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if ($data['status'] === 'A') {
                $status = "D";
            } elseif ($data['status'] === 'D') {
                $status = "A";
            }
            $database->update("health", ["status" => $status], ["id" => $data['id']]);
            $jatbi->logs('health', 'status', ["data" => $data, "status" => $status]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-trang-thai'], 'sound' => $setting['site_sound']]);
        } else {
            echo json_encode(['status' => 'error', 'content' => $lang['cap-nhat-that-bai'],]);
        }
    }
} elseif ($router['1'] == 'vaccination') {
    $jatbi->permission('vaccination');
    $count = $database->count(
        "vaccination",
        [
            'AND' => [
                "deleted" => 0,
            ]
        ]
    );
    $pg = $_GET['pg'];
    if (!$pg)
        $pg = 1;
    $datas = $database->select("vaccination", "*", [
        "AND" => [
            "OR" => [

                'name[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'namevacxin[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'date[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),


            ],
            'students[<>]' => ($xss->xss($_GET['students']) == '') ?: [$xss->xss($_GET['students']), $xss->xss($_GET['students'])],
            'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
            "deleted" => 0,
            "school" => $school_id,
        ],
        "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
        "ORDER" => [
            "id" => "DESC",
        ]
    ]);
    $page = $jatbi->pages($count, $setting['site_page'], $pg);
    $templates = $setting['site_backend'] . 'profiles.tpl';
} elseif ($router['1'] == 'vaccination-add') {
    $jatbi->permission('vaccination.add');
    $ajax = 'true';
    if (isset($_POST['token'])) {
        $handle = new Upload($_FILES['avatar']);
        if ($_POST['token'] != $_SESSION['csrf']['token']) {
            echo json_encode(['status' => 'error', 'content' => $lang['token-khong-dung']]);
        } elseif ($_POST['name'] == "" || $_POST['namevacxin'] == "" || $_POST['students'] == "" || $_POST['date'] == "") {
            echo json_encode(['status' => 'error', 'content' => $lang['loi-trong'], 'sound' => $setting['site_sound']]);
        }

        if ($handle->processed && $_POST['name'] && $_POST['namevacxin'] && $_POST['students'] && $_POST['date']) {
            $insert = [
                "date" => date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date']))),
                "name" => $xss->xss($_POST['name']),
                "namevacxin" => $xss->xss($_POST['namevacxin']),
                "students" => $xss->xss($_POST['students']),
                "status" => $xss->xss($_POST['status']),
                "school" => $school_id,
            ];
            $database->insert("vaccination", $insert);
            $jatbi->logs('vaccination', 'add', $insert);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
        }
    } else {
        $templates = $setting['site_backend'] . 'profiles.tpl';
    }
} elseif ($router['1'] == 'vaccination-edit') {
    $jatbi->permission('vaccination.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("vaccination", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if (isset($_POST['token'])) {
                $partten = "/^[A-Za-z0-9_\.]{" . $setting['site_characters'] . ",32}$/";

                $handle = new Upload($_FILES['avatar']);
                if ($_POST['token'] != $_SESSION['csrf']['token']) {
                    echo json_encode(['status' => 'error', 'content' => $lang['token-khong-dung']]);
                } elseif ($_POST['name'] == "" || $_POST['namevacxin'] == "" || $_POST['students'] == "" || $_POST['date'] == "") {
                    echo json_encode(['status' => 'error', 'content' => $lang['loi-trong'], 'sound' => $setting['site_sound']]);
                }

                if ($handle->processed && $_POST['name'] && $_POST['namevacxin'] && $_POST['students'] && $_POST['date']) {
                    $insert = [
                        "date" => date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date']))),
                        "name" => $xss->xss($_POST['name']),
                        "namevacxin" => $xss->xss($_POST['namevacxin']),
                        "students" => $xss->xss($_POST['students']),
                        "status" => $xss->xss($_POST['status']),
                        "school" => $school_id,
                    ];
                    $database->update("vaccination", $insert, ["id" => $data['id']]);
                    $jatbi->logs('vaccination', 'edit', $insert);
                    echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
                }
            } else {
                $templates = $setting['site_backend'] . 'profiles.tpl';
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
} elseif ($router['1'] == 'vaccination-delete') {
    $jatbi->permission('vaccination.delete');
    $ajax = 'true';
    if ($router['2']) {
        $datas = $database->select("vaccination", "*", ["id" => explode(',', $xss->xss($router['2']))]);
        if (isset($_POST['submit'])) {
            $jatbi->logs('vaccination', 'delete', $datas);
            $database->update("vaccination", ["deleted" => 1,], ["id" => explode(',', $xss->xss($router['2']))]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
        } else {
            $templates = $setting['site_backend'] . 'profiles.tpl';
        }
    } else {
        header("HTTP/1.0 404 Not Found");
        die();
    }
} elseif ($router['1'] == 'vaccination-status') {
    $jatbi->permission('vaccination.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("vaccination", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if ($data['status'] === 'A') {
                $status = "D";
            } elseif ($data['status'] === 'D') {
                $status = "A";
            }
            $database->update("vaccination", ["status" => $status], ["id" => $data['id']]);
            $jatbi->logs('vaccination', 'status', ["data" => $data, "status" => $status]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-trang-thai'], 'sound' => $setting['site_sound']]);
        } else {
            echo json_encode(['status' => 'error', 'content' => $lang['cap-nhat-that-bai'],]);
        }
    }
} elseif ($router['1'] == 'point') {
    $jatbi->permission('point');
    $date = explode('-',$xss->xss($_GET['date']));
    $date_from = ($_GET['date']=='')?date('Y-01-01'):date('Y-m-d',strtotime(str_replace('/','-',$date[0])));
    $date_to = ($_GET['date']=='')?date('Y-m-d'):date('Y-m-d',strtotime(str_replace('/','-',$date[1])));
    $count = $database->count(
        "scores",
        [
            'AND' => [
                "deleted" => 0,
                "school" => $school_id,
            ]
        ]
    );
    $pg = $_GET['pg'];
    if (!$pg)
        $pg = 1;
    $datas = $database->select("scores", "*", [
        "AND" => [
            "OR" => [
                'score[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
            ],
            'subject[<>]' => ($xss->xss($_GET['subject']) == '') ?: [$xss->xss($_GET['subject']), $xss->xss($_GET['subject'])],
            'typescore[<>]' => ($xss->xss($_GET['typescore']) == '') ?: [$xss->xss($_GET['typescore']), $xss->xss($_GET['typescore'])],
            'semester[<>]' => ($xss->xss($_GET['semester']) == '') ?: [$xss->xss($_GET['semester']), $xss->xss($_GET['semester'])],
            'teacher[<>]' => ($xss->xss($_GET['teacher']) == '') ?: [$xss->xss($_GET['teacher']), $xss->xss($_GET['teacher'])],
            'accounts[<>]' => ($xss->xss($_GET['accounts']) == '') ?: [$xss->xss($_GET['accounts']), $xss->xss($_GET['accounts'])],
            'date[<>]' => ($xss->xss($_GET['date']) == '') ?: [$xss->xss($_GET['date']), $xss->xss($_GET['date'])],
            'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
            "deleted" => 0,
            "school" => $school_id,
        ],
        "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
        "ORDER" => [
            "id" => "DESC",
        ]
    ]);
    $page = $jatbi->pages($count, $setting['site_page'], $pg);
    $templates = $setting['site_backend'] . 'profiles.tpl';
} elseif ($router['1'] == 'point-add') {
    $jatbi->permission('point.add');
    $ajax = 'true';
    $date = date("Y-m-d");
    $course = $database->select("course", "*", [
        "school" => $school_id,
        "status" => 'A',
        "deleted" => 0,
    ]);
    foreach ($course as $value) {
        $date_timestamp = strtotime($date);
        $start_timestamp = strtotime($value['startdate']);
        $end_timestamp = strtotime($value['enddate']);

        if ($date_timestamp >= $start_timestamp && $date_timestamp <= $end_timestamp) {
            $class_course = $database->select("class_diagram", "*", [
                "AND" => [
                    "deleted" => 0,
                    'course' => $value['id'],
                    "school" => $school_id,
                ],

                "ORDER" => [
                    "id" => "DESC",
                ]
            ]);
        }
    }
    
    $typescores = $database->get("typescore", "name", ["school"        =>$school_id,"id" => $xss->xss($_POST['typescore']), "deleted" => 0, "status" => 'A']);
    $ass = $database->get("assigning_teachers", "*", ["id" => $xss->xss($_POST['assigning_teachers']), "deleted" => 0, "status" => 'A', "school" => $school_id]);
    $class = $database->get("class", "name", [
        "AND" => [
            "id"=>$database->get("class_diagram","class",['id'=>$ass['class_diagram']]),
            "deleted" => 0,
            "school" => $school_id,
        ]
    ]);
    if (isset($_POST['token'])) {

        if ($_POST['token'] != $_SESSION['csrf']['token']) {
            echo json_encode(['status' => 'error', 'content' => $lang['token-khong-dung']]);
        } elseif ($_POST['assigning_teachers'] == "" || $_POST['typescore'] == "") {
            echo json_encode(['status' => 'error', 'content' => $lang['loi-trong'], 'sound' => $setting['site_sound']]);
        }
        if ($_POST['assigning_teachers'] && $_POST['typescore']) {
            foreach ($_POST['questions_content'] as $key => $value) {
                if ($value != '' && $xss->xss($_POST['questions_point'][$key]) != '') {
                    $insert = [
                        "typescore" => $xss->xss($_POST['typescore']),
                        "arrange_class" => $xss->xss($_POST['questions_content'][$key]),
                        "score" => $xss->xss($_POST['questions_point'][$key]),
                        "assigning_teachers" => $xss->xss($_POST['assigning_teachers']),
                        "date" => date('Y-m-d'),
                        "status" => $xss->xss($_POST['status']),
                        "school" => $school_id,
                        "accounts" => $account['id'],

                    ];
                    $database->insert("scores", $insert);
                    $jatbi->logs('scores', 'add', $insert);
                }
            }
            // Select data from the "arrange_class" table
            $arr = $database->select(
                "arrange_class",
                "*",
                [
                    "class_diagram" => $xss->xss($_POST['class_course']),
                    "deleted" => 0,
                    "status" => 'A',
                    "school" => $school_id
                ]
            );

            // Fetch device IDs for each result in $arr
            $device = [];
            foreach ($arr as $a) {
                $parent = $database->get(
                    "students",
                    "parent",
                    [
                        "id" => $a['students'],
                        "deleted" => 0,
                        "status" => 'A',
                        "school" => $school_id
                    ]
                );

                $devices = $database->select(
                    "device_parent",
                    "device_id",
                    [
                        "parent" => $parent,
                        "school" => $school_id,
                        "deleted" => 0,
                        "status" => 'A'
                    ]
                );

                $device = array_merge($device, $devices);
            }



            function sendNotification($title, $message, $device)
            {
                $content = array(
                    "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                );

                $fields = [
                    'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6',
                    // ID ứng dụng OneSignal của bạn
                    'include_player_ids' => $device,
                    // Danh sách các device token
                    'contents' => $content,
                    'headings' => array("en" => $title) // Tiêu đề thông báo
                ];

                $fields = json_encode($fields);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                )
                );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $result = curl_exec($ch);

                if ($result === FALSE) {
                    die('Curl failed: ' . curl_error($ch));
                }

                curl_close($ch);

                return $result;
            }

            // Gọi hàm sendNotification để gửi thông báo đẩy
            $assigning_teachers = $database->get("assigning_teachers", "subject", ["id" => $xss->xss($_POST['assigning_teachers']), "deleted" => 0, "status" => 'A', "school" => $school_id]);
            $subject = $database->get("subject", "name", ["id" => $assigning_teachers, "deleted" => 0, "status" => 'A', "school" => $school_id]);
            $title = $school['name'];
            $message = "Hệ thống đã nhập điểm " . $typescores . ' môn ' . $subject .' lớp '.$class;

            $result = sendNotification($title, $message, $device);

            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
        }
    } else {
        $templates = $setting['site_backend'] . 'profiles.tpl';
    }
} elseif ($router['1'] == 'point-edit') {
    $jatbi->permission('point.edit');
    $ajax = 'true';

    if ($router['2']) {
        $data = $database->get("scores", "*", ["id" => $xss->xss($router['2'])]);
        $arrange_class = $database->select("arrange_class", "*", [
            "AND" => [
                "id" => $data['arrange_class'],
                "deleted" => 0,
                "school" => $school_id,
            ],
        ]);
        $assigning_teachers = $database->select("assigning_teachers", "*", [
            "AND" => [
                "id" => $data['assigning_teachers'],
                "deleted" => 0,
                "school" => $school_id,
            ],
        ]);
        if ($data > 1) {
            if (isset($_POST['token'])) {
                $partten = "/^[A-Za-z0-9_\.]{" . $setting['site_characters'] . ",32}$/";

                $handle = new Upload($_FILES['avatar']);
                if ($_POST['token'] != $_SESSION['csrf']['token']) {
                    echo json_encode(['status' => 'error', 'content' => $lang['token-khong-dung']]);
                } elseif ($_POST['assigning_teachers'] == "" || $_POST['students'] == "" || $_POST['typescore'] == "" || $_POST['score'] == "") {
                    echo json_encode(['status' => 'error', 'content' => $lang['loi-trong'], 'sound' => $setting['site_sound']]);
                }
                if ($_POST['assigning_teachers'] && $_POST['students'] && $_POST['typescore'] && $_POST['score']) {
                    $insert = [

                        "arrange_class" => $xss->xss($_POST['students']),
                        "typescore" => $xss->xss($_POST['typescore']),
                        "score" => $xss->xss($_POST['score']),
                        "date" => date('Y-m-d'),
                        "assigning_teachers" => $xss->xss($_POST['assigning_teachers']),
                        "accounts" => $account['id'],
                        "status" => $xss->xss($_POST['status']),
                        "school" => $school_id,
                    ];
                    $database->update("scores", $insert, ["id" => $data['id']]);
                    $jatbi->logs('scores', 'edit', $insert);
                    echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
                }
            } else {
                $templates = $setting['site_backend'] . 'profiles.tpl';
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
} elseif ($router['1'] == 'point-delete') {
    $jatbi->permission('point.delete');
    $ajax = 'true';
    if ($router['2']) {
        $datas = $database->select("scores", "*", ["id" => explode(',', $xss->xss($router['2']))]);
        if (isset($_POST['submit'])) {
            $jatbi->logs('scores', 'delete', $datas);
            $database->update("scores", ["deleted" => 1,], ["id" => explode(',', $xss->xss($router['2']))]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
        } else {
            $templates = $setting['site_backend'] . 'profiles.tpl';
        }
    } else {
        header("HTTP/1.0 404 Not Found");
        die();
    }
} elseif ($router['1'] == 'point-status') {
    $jatbi->permission('point.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("scores", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if ($data['status'] === 'A') {
                $status = "D";
            } elseif ($data['status'] === 'D') {
                $status = "A";
            }
            $database->update("scores", ["status" => $status], ["id" => $data['id']]);
            $jatbi->logs('scores', 'status', ["data" => $data, "status" => $status]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-trang-thai'], 'sound' => $setting['site_sound']]);
        } else {
            echo json_encode(['status' => 'error', 'content' => $lang['cap-nhat-that-bai'],]);
        }
    }
} elseif ($router['1'] == 'furlough') {
    $jatbi->permission('furlough');
    $count = $database->count(
        "furlough",
        [
            'AND' => [
                "deleted" => 0,
            ]
        ]
    );
    $pg = $_GET['pg'];
    if (!$pg)
        $pg = 1;
    $datas = $database->select("furlough", "*", [
        "AND" => [
            "OR" => [

                'date_start[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'date_end[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'datecurrent[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'numberday[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                'reason[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),


            ],
            'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
            "deleted" => 0,
            "school" => $school_id,
        ],
        "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
        "ORDER" => [
            "id" => "DESC",
        ]
    ]);
    $page = $jatbi->pages($count, $setting['site_page'], $pg);
    $templates = $setting['site_backend'] . 'profiles.tpl';
} elseif ($router['1'] == 'furlough-status') {
    $jatbi->permission('furlough.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("furlough", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if ($data['status'] === 'A') {
                $status = "D";
            } elseif ($data['status'] === 'D') {
                $status = "A";
            }
            $database->update("furlough", ["status" => $status], ["id" => $data['id']]);
            $jatbi->logs('furlough', 'status', ["data" => $data, "status" => $status]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-trang-thai'], 'sound' => $setting['site_sound']]);
        } else {
            echo json_encode(['status' => 'error', 'content' => $lang['cap-nhat-that-bai'],]);
        }
    }
} elseif ($router['1'] == 'furlough-edit') {
    $jatbi->permission('furlough.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("furlough", "*", ["school" => $school_id, "id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if (isset($_POST['token'])) {
                $partten = "/^[A-Za-z0-9_\.]{" . $setting['site_characters'] . ",32}$/";

                $handle = new Upload($_FILES['avatar']);
                if ($_POST['token'] != $_SESSION['csrf']['token']) {
                    echo json_encode(['status' => 'error', 'content' => $lang['token-khong-dung']]);
                }
                $counts = 1;
                if ($_POST['statu'] == 'C') {
                    $counts = 2;
                }

                if ($_POST['date_start'] && $_POST['date_end'] && $_POST['datecurrent'] && $_POST['numberday'] && $_POST['reason'] && $_POST['arrange_class'] && $_POST['statu']) {
                    $insert = [
                        "date_start" => $xss->xss($_POST['date_start']),
                        "date_end" => $xss->xss($_POST['date_end']),
                        "datecurrent" => $xss->xss($_POST['datecurrent']),
                        "numberday" => $xss->xss($_POST['numberday']),
                        "reason" => $xss->xss($_POST['reason']),
                        "arrange_class" => $xss->xss($_POST['arrange_class']),
                        "statu" => $xss->xss($_POST['statu']),
                        "status" => $xss->xss($_POST['status']),
                        "count" => $counts,
                        "school" => $school_id,
                    ];
                    $database->update("furlough", $insert, ["id" => $data['id']]);
                    $arr = $database->get("arrange_class", "*", ["id" => $xss->xss($_POST['arrange_class']), "deleted" => 0, "status" => 'A', "school" => $school_id]);
                    $device = $database->select("device_parent", "device_id", [
                        "parent" => $database->get("students", "parent", ["id" => $arr['students'], "deleted" => 0, "status" => 'A', "school" => $school_id]),
                        "school" => $school_id,
                        "deleted" => 0,
                        "status" => 'A'
                    ]);


                    function sendNotification($title, $message, $device)
                    {
                        $content = array(
                            "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                        );

                        $fields = [
                            'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6',
                            // ID ứng dụng OneSignal của bạn
                            'include_player_ids' => $device,
                            // Danh sách các device token
                            'contents' => $content,
                            'headings' => array("en" => $title) // Tiêu đề thông báo
                        ];

                        $fields = json_encode($fields);

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json; charset=utf-8',
                            'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                        )
                        );
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HEADER, false);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                        $result = curl_exec($ch);

                        if ($result === FALSE) {
                            die('Curl failed: ' . curl_error($ch));
                        }

                        curl_close($ch);

                        return $result;
                    }

                    // Gọi hàm sendNotification để gửi thông báo đẩy
                    $student = $database->get("students", "fullname", ["id" => $arr['students'], "deleted" => 0, "status" => 'A', "school" => $school_id]);
                    $title = $school['name'];
                    if ($_POST['statu'] == 'C') {
                        $message = "Xin nghỉ phép của " . $student . " KHÔNG được duyệt";
                    } elseif ($_POST['statu'] == 'D') {
                        $message = "Xin nghỉ phép của " . $student . " ĐÃ được duyệt";
                    }
                    $result = sendNotification($title, $message, $device);
                    $jatbi->logs('furlough', 'edit', $insert);
                    echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
                }
            } else {
                $templates = $setting['site_backend'] . 'profiles.tpl';
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
} elseif ($router['1'] == 'furlough-delete') {
    $jatbi->permission('furlough.delete');
    $ajax = 'true';
    if ($router['2']) {
        $datas = $database->select("furlough", "*", ["id" => explode(',', $xss->xss($router['2']))]);
        if (isset($_POST['submit'])) {
            $jatbi->logs('furlough', 'delete', $datas);
            $database->update("furlough", ["deleted" => 1,], ["id" => explode(',', $xss->xss($router['2']))]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
        } else {
            $templates = $setting['site_backend'] . 'profiles.tpl';
        }
    } else {
        header("HTTP/1.0 404 Not Found");
        die();
    }
} elseif ($router['1'] == 'priority_object') {
    $jatbi->permission('priority_object');
    $count = $database->count(
        "priority_object",
        [
            'AND' => [
                'name[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                "deleted" => 0,
            ]
        ]
    );
    $pg = $_GET['pg'];
    if (!$pg)
        $pg = 1;
    $datas = $database->select("priority_object", "*", [
        "AND" => [
            "OR" => [
                //'id[~]'       => ($xss->xss($_GET['id'])=='')?'%':$xss->xss($_GET['id']),
                'name[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
            ],
            'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
            "deleted" => 0,
            "school" => $school_id,
        ],
        "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
        "ORDER" => [
            "id" => "DESC",
        ]
    ]);
    $page = $jatbi->pages($count, $setting['site_page'], $pg);
    $templates = $setting['site_backend'] . 'profiles.tpl';
} elseif ($router['1'] == 'priority_object-add') {
    $jatbi->permission('priority_object.add');
    $ajax = 'true';
    if (isset($_POST['token'])) {
        $handle = new Upload($_FILES['avatar']);
        if ($_POST['token'] != $_SESSION['csrf']['token']) {
            echo json_encode(['status' => 'error', 'content' => $lang['token-khong-dung']]);
        } elseif ($_POST['name'] == "") {
            echo json_encode(['status' => 'error', 'content' => $lang['loi-trong'], 'sound' => $setting['site_sound']]);
        }
        if ($handle->processed && $_POST['name']) {
            $insert = [
                "name" => $xss->xss($_POST['name']),
                "exemptions" => $xss->xss($_POST['exemptions']),
                "status" => $xss->xss($_POST['status']),
                "school" => $school_id,
            ];
            $database->insert("priority_object", $insert);
            $jatbi->logs('priority_object', 'add', $insert);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
        }
    } else {
        $templates = $setting['site_backend'] . 'profiles.tpl';
    }
} elseif ($router['1'] == 'priority_object-edit') {
    $jatbi->permission('priority_object.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("priority_object", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if (isset($_POST['token'])) {
                $partten = "/^[A-Za-z0-9_\.]{" . $setting['site_characters'] . ",32}$/";

                $handle = new Upload($_FILES['avatar']);
                if ($_POST['token'] != $_SESSION['csrf']['token']) {
                    echo json_encode(['status' => 'error', 'content' => $lang['token-khong-dung']]);
                } elseif ($_POST['name'] == "") {
                    echo json_encode(['status' => 'error', 'content' => $lang['loi-trong'], 'sound' => $setting['site_sound']]);
                }
                if ($handle->processed && $_POST['name']) {
                    $insert = [
                        "name" => $xss->xss($_POST['name']),
                        "exemptions" => $xss->xss($_POST['exemptions']),
                        "status" => $xss->xss($_POST['status']),
                        "school" => $school_id,
                    ];
                    $database->update("priority_object", $insert, ["id" => $data['id']]);
                    $jatbi->logs('priority_object', 'edit', $insert);
                    echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
                }
            } else {
                $templates = $setting['site_backend'] . 'profiles.tpl';
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
} elseif ($router['1'] == 'priority_object-delete') {
    $jatbi->permission('priority_object.delete');
    $ajax = 'true';
    if ($router['2']) {
        $datas = $database->select("priority_object", "*", ["id" => explode(',', $xss->xss($router['2']))]);
        if (isset($_POST['submit'])) {
            $jatbi->logs('priority_object', 'delete', $datas);
            $database->update("priority_object", ["deleted" => 1,], ["id" => explode(',', $xss->xss($router['2']))]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
        } else {
            $templates = $setting['site_backend'] . 'profiles.tpl';
        }
    } else {
        header("HTTP/1.0 404 Not Found");
        die();
    }
} elseif ($router['1'] == 'priority_object-status') {
    $jatbi->permission('priority_object.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("priority_object", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if ($data['status'] === 'A') {
                $status = "D";
            } elseif ($data['status'] === 'D') {
                $status = "A";
            }
            $database->update("priority_object", ["status" => $status], ["id" => $data['id']]);
            $jatbi->logs('priority_object', 'status', ["data" => $data, "status" => $status]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-trang-thai'], 'sound' => $setting['site_sound']]);
        } else {
            echo json_encode(['status' => 'error', 'content' => $lang['cap-nhat-that-bai'],]);
        }
    }
} elseif ($router['1'] == 'allergy') {
    $jatbi->permission('allergy');
    $count = $database->count(
        "allergy",
        [
            'AND' => [
                'name[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
                "deleted" => 0,
            ]
        ]
    );
    $pg = $_GET['pg'];
    if (!$pg)
        $pg = 1;
    $datas = $database->select("allergy", "*", [
        "AND" => [
            "OR" => [
                //'id[~]'       => ($xss->xss($_GET['id'])=='')?'%':$xss->xss($_GET['id']),
                'name[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),
            ],
            'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
            "deleted" => 0,
            "school" => $school_id,
        ],
        "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
        "ORDER" => [
            "id" => "DESC",
        ]
    ]);
    $page = $jatbi->pages($count, $setting['site_page'], $pg);
    $templates = $setting['site_backend'] . 'profiles.tpl';
} elseif ($router['1'] == 'allergy-add') {
    $jatbi->permission('allergy.add');
    $ajax = 'true';
    if (isset($_POST['token'])) {

        if ($_POST['token'] != $_SESSION['csrf']['token']) {
            echo json_encode(['status' => 'error', 'content' => $lang['token-khong-dung']]);
        } elseif ($_POST['name'] == "") {
            echo json_encode(['status' => 'error', 'content' => $lang['loi-trong'], 'sound' => $setting['site_sound']]);
        }
        if ($_POST['name']) {
            $insert = [
                "name" => $xss->xss($_POST['name']),
                "status" => $xss->xss($_POST['status']),
                "school" => $school_id,
            ];
            $database->insert("allergy", $insert);
            $jatbi->logs('allergy', 'add', $insert);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
        }
    } else {
        $templates = $setting['site_backend'] . 'profiles.tpl';
    }
} elseif ($router['1'] == 'allergy-edit') {
    $jatbi->permission('allergy.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("allergy", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if (isset($_POST['token'])) {
                $partten = "/^[A-Za-z0-9_\.]{" . $setting['site_characters'] . ",32}$/";


                if ($_POST['token'] != $_SESSION['csrf']['token']) {
                    echo json_encode(['status' => 'error', 'content' => $lang['token-khong-dung']]);
                } elseif ($_POST['name'] == "") {
                    echo json_encode(['status' => 'error', 'content' => $lang['loi-trong'], 'sound' => $setting['site_sound']]);
                }
                if ($_POST['name']) {
                    $insert = [
                        "name" => $xss->xss($_POST['name']),

                        "status" => $xss->xss($_POST['status']),
                        "school" => $school_id,
                    ];
                    $database->update("allergy", $insert, ["id" => $data['id']]);
                    $jatbi->logs('allergy', 'edit', $insert);
                    echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
                }
            } else {
                $templates = $setting['site_backend'] . 'profiles.tpl';
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
} elseif ($router['1'] == 'allergy-delete') {
    $jatbi->permission('allergy.delete');
    $ajax = 'true';
    if ($router['2']) {
        $datas = $database->select("allergy", "*", ["id" => explode(',', $xss->xss($router['2']))]);
        if (isset($_POST['submit'])) {
            $jatbi->logs('allergy', 'delete', $datas);
            $database->update("allergy", ["deleted" => 1,], ["id" => explode(',', $xss->xss($router['2']))]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
        } else {
            $templates = $setting['site_backend'] . 'profiles.tpl';
        }
    } else {
        header("HTTP/1.0 404 Not Found");
        die();
    }
} elseif ($router['1'] == 'allergy-status') {
    $jatbi->permission('allergy.edit');
    $ajax = 'true';
    if ($router['2']) {
        $data = $database->get("allergy", "*", ["id" => $xss->xss($router['2'])]);
        if ($data > 1) {
            if ($data['status'] === 'A') {
                $status = "D";
            } elseif ($data['status'] === 'D') {
                $status = "A";
            }
            $database->update("allergy", ["status" => $status], ["id" => $data['id']]);
            $jatbi->logs('allergy', 'status', ["data" => $data, "status" => $status]);
            echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-trang-thai'], 'sound' => $setting['site_sound']]);
        } else {
            echo json_encode(['status' => 'error', 'content' => $lang['cap-nhat-that-bai'],]);
        }
    }
} elseif ($router['1'] == 'profiles') {
    $jatbi->permission('students');
    if ($router['2']) {


        $datas = $database->get("students", "*", [
            "AND" => [
                'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
                "deleted" => 0,

                "id" => $router['2'],
            ],
            "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
            "ORDER" => [
                "id" => "DESC",
            ]
        ]);
        $arrange_classs = $database->select("arrange_class", "*", ["school" => $school_id, "students" => $router['2']]);
        $templates = $setting['site_backend'] . 'profiles.tpl';
    }
}

?>