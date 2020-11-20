<?php

App::uses('AppController', 'Controller');

class MemberAppController extends AppController {

    public function beforeFilter() {
        
        parent::beforeFilter();    
        
        $params = $this->request->params;
        if (isset($params['prefix']) && $params['prefix'] == 'admin') {
            $this->theme  = "CakeAdminLTE";
            $this->layout  = "default";
        }
    }

	public function filter_email_info($email) {
        $findme   = '@';
        $pos = strpos($email, $findme);
        $extension = "";

        if ($pos >= 0)  {
            $extension = substr($email, $pos + 1, strlen($email) - $pos - 1);
        }

        $first_two_character = substr($email, 0, 2);  // get first 2 character
        return $first_two_character . "********@" . $extension ;
    } 

    public function check_data($data, $role_id, $list_user, $school_id) {

        $check_duplicate = $result =  $check_duplicate_email = array();
        $is_first = true;
        $row = 1;
        $message        = "";
        $color          = "green";
        $email_column   = "";

        foreach ($data as $val) {
            $wrong_format_flag    = $empty_flag     = $no_space_flag    = $duplicate_flag       = $exists_in_db     = $email_exists_in_db = false;
            $empty_message  = $no_space_message = $duplicate_message    = $exist_message    = $email_exist_message = "";
            $error          = $total_errors = array();
            
            if  (isset($val[5]) && $val[5] != NULL || !empty($val[5])) {
                $wrong_format_flag = true;      // wrong import template
                goto add_data;
            }
            
            if ($is_first) {
                $is_first = false;
                continue;
            }

            $obj_Member = ClassRegistry::init('Member.Member');
            $obj_MemberLoginMethod = ClassRegistry::init('Member.MemberLoginMethod');


                if  ($val[0] == NULL || empty($val[0])) {
                    $error[] = "Column Username";
                    $empty_flag = true;
                }

                if  ($val[1] == NULL || empty($val[1])) {
                    $error[] = "Column Password";
                    $empty_flag = true;
                }

                if  ($val[2] == NULL || empty($val[2])) {
                    $error[] = "Column Display name";
                    $empty_flag = true;
                }

                // all column empty
                if ( ($val[0] == NULL || empty($val[0])) &&  
                     ($val[1] == NULL || empty($val[1])) &&
                     ($val[2] == NULL || empty($val[2])) ) {
                    continue;
                }
               
                if ($empty_flag) {
                    $empty_message = implode(", ", $error) . " is empty";
                    $total_errors[] = $empty_message;
                    goto add_data;
                }

                $email_column = strtolower($val[3]);

            // } elseif ($role_id == Environment::read('role.teacher')) {
             
            //     if  (isset($val[5]) && $val[5] != NULL || !empty($val[5])) {
            //         $wrong_format_flag = true;      // wrong import template
            //         goto add_data;
            //     }
            //     if  ($val[0] == NULL || empty($val[0])) {
            //         $error[] = "Column Username";
            //         $empty_flag = true;
            //     }

            //     if  ($val[1] == NULL || empty($val[1])) {
            //         $error[] = "Column Password";
            //         $empty_flag = true;
            //     }

            //     if  ($val[1] == NULL || empty($val[2])) {
            //         $error[] = "Column Display name";
            //         $empty_flag = true;
            //     }
            //     // all column empty
            //     if ( ($val[0] == NULL || empty($val[0])) &&  
            //         ($val[1] == NULL || empty($val[1])) && 
            //         ($val[2] == NULL || empty($val[2])) ) {
            //         continue;
            //     }
               
            //     if ($empty_flag) {
            //         $empty_message = implode(", ", $error) . " is empty";
            //         $total_errors[] = $empty_message;
            //         goto add_data;
            //     }

            //     $email_column = strtolower($val[3]);
            // }
            
            // check email (if exist)
            if ($email_column != NULL && !empty($email_column)) {

                $conditions = array(
                    'Member.email' 			=> $email_column,
                );
                
                if ($obj_Member->hasAny($conditions)) {			// don't exists username
                    $email_exists_in_db   = true;
                    $email_exist_message  = "This is a duplicated email in this school (" . $email_column . ")";
                    $total_errors[] = $email_exist_message;
                    goto add_data;
                }
            }
            
            $conditions = array(
                array('MemberLoginMethod.username' 			=> strtolower($val[0])),
                array('MemberLoginMethod.school_id'         => $school_id),
            );
            
            if ($obj_MemberLoginMethod->hasAny($conditions)) {			// don't exists username
                $exists_in_db   = true;
                $exist_message  = "This is a duplicated data in this school (" . $val[0] . ")";
                $total_errors[] = $exist_message;
                goto add_data;
            }


            if (preg_match('/\s/', $val[0])) {     // exist space in username
                $no_space_flag = true;
                $no_space_message =  $val[0] . "-username not allow space";
                $total_errors[] = $no_space_message;
                goto add_data;
            }

            if (in_array($val[0], $list_user)) {
                $duplicate_flag = true;
                $duplicate_message = $val[0] . "-is duplicate in DB!";
                $total_errors[] = $duplicate_message;
                goto add_data;
            } 
 
            if (in_array($val[0], $check_duplicate)) {
                $duplicate_flag = true;
                $duplicate_message = $val[0] . "-is duplicate in import file!";
                $total_errors[] = $duplicate_message;

            } elseif ($email_column != NULL && in_array($email_column, $check_duplicate_email)) {
                $email_exists_in_db = true;
                $duplicate_message = $val[0] . "-is duplicate in import file!";
                $total_errors[] = $duplicate_message;

            } else {
                $result[] = $val;
                $check_duplicate_email[] = $email_column;
                $check_duplicate[] = $val[0];
            }
            
            add_data:
            if ($wrong_format_flag) {
                $message = "Wrong import template!!!";
                $color = "red";
                goto return_data;
            } 
            if (!$empty_flag && !$no_space_flag && !$duplicate_flag && !$exists_in_db && !$email_exists_in_db) {
                $message = $message . "-Record " . $row . ": (". $val[0] . ") Import Succeed!<br>";

            } else {
                $message = $message . "-Record " . $row . ": (". $val[0] . ") Cannot Import! Error: " . implode(", ", $total_errors) . "<br>";
                $color = "red";
            }

            $row = $row + 1;
        }

        return_data: 
        return array(
            'message'    => $message, 
            'data'       => $result,         // list data need add to DB,
            'color'      => $color,
        );
    }

    // for Teacher / Student without email address, check if there is any existing "username" in the same SCHOOL
    
    
    // for Teacher / Student exist email address, check if there is any existing "username" in the same SCHOOL
     // if NOT EXIST username --> create new member
    
    // if NOT EXIST --> create new member
    // if EXISTS --> check if the GROUP NAME changed
    // 1b i) if NOT changed --> update existing record (e.g. name, class no, email, phone number)
    // 1b ii) if changed --> add a new GROUP mapping
    public function check_data_before_import($data, $school_id, $role_id, $group_id) {
        $is_first_row   = true;
        $row            = 1;
        $message        = "";
        $color          = "green";
        $email_column   = "";

        $result                   = array();
        $data_Member              = array();
        $data_MemberLoginMethod   = array();
        $data_MemberLanguage      = array();
        $data_MembersGroup        = array();
        $data_MemberRole          = array();

        $obj_Member             = ClassRegistry::init('Member.Member');
        $obj_MemberLoginMethod  = ClassRegistry::init('Member.MemberLoginMethod');
        $obj_MemberLanguage     = ClassRegistry::init('Member.MemberLanguage');
        $obj_MembersGroup       = ClassRegistry::init('Member.MembersGroup');
        $obj_MemberRole         = ClassRegistry::init('Member.MemberRole');

        $wrong_format_flag      = false;

        foreach ($data as $val) {
            $empty_flag         = $no_space_flag    = $edit_flag     = $cannot_edit_flag    = false;
            $error              = $total_errors = array();
            $add_new_group      = false;

            if ($is_first_row) {    // skip first row
                $is_first_row = false;
                continue;
            }
         
            $username_column        = strtolower($val[0]);
            $password_column        = $val[1];
            $display_name_column    = $val[2];
            $email_column           = strtolower($val[3]);
            $phone_number_column    = $val[4];

            if  (isset($val[5]) && $val[5] != NULL || !empty($val[5])) {
                $wrong_format_flag = true;      // wrong import template
                goto add_data;
            }

            if  ($username_column == NULL || empty($username_column)) {
                $error[] = "Column Username";
                $empty_flag = true;
            }

            if  ($password_column == NULL || empty($password_column)) {
                $error[] = "Column Password";
                $empty_flag = true;
            }

            if  ($display_name_column == NULL || empty($display_name_column)) {
                $error[] = "Column Display name";
                $empty_flag = true;
            }

            if (    ($username_column == NULL || empty($username_column)) &&  
                    ($password_column == NULL || empty($password_column)) &&
                    ($display_name_column == NULL || empty($display_name_column)) ) {
                continue;
            }
            
            if ($empty_flag) {
                $total_errors[] = implode(", ", $error) . " is empty";
                goto add_data;
            }
            
            if (preg_match('/\s/', $username_column)) {     // exist space in username
                $no_space_flag = true;
                $total_errors[] =  $username_column . "-username not allow space";
                goto add_data;
            }

            if ($email_column != NULL && !empty($email_column)) {   // exist email input by user -> check
                $conditions = array(
                    'Member.email' 			=> $email_column,
                );
                if (!$result_Member = $obj_Member->get_obj_with_conditions($conditions)) {    // don't exist email in system -> add new

                    $conditions = array(
                        'MemberLoginMethod.username' 		=> $username_column,
                        'MemberLoginMethod.school_id'       => $school_id
                    );
                    if ($result_MemberLoginMethod = $obj_MemberLoginMethod->get_obj_with_conditions($conditions)) {   // exist member login method , edit 
                        // check member role
                        $cond = array(
                            'MemberRole.school_id'  => $school_id,
                            'MemberRole.role_id'    => $role_id,
                            'MemberRole.member_id'  => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                        );
                    
                        if (!$obj_MemberRole->hasAny($cond)) {
                            $data_MemberRole[] = array(
                                'school_id'             => $school_id,
                                'role_id'               => $role_id,
                                'original_member_id'    => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                                'member_id'             => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                            );
                        }
                
                        $data_MemberLoginMethod[] = array(
                            'id'                            => $result_MemberLoginMethod['MemberLoginMethod']['id'],
                            'username'                      => $username_column,
                            'password'                      => $obj_Member->set_password($password_column),
                            'display_name'                  => $display_name_column,
                        );
        
                        // update member back from login method
                        $data_Member[] = array(
                            'id'                    => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                            'email'                 => $email_column,
                            'verified'              => true,
                            'phone_number'          => $phone_number_column,
                        );

                        // add member language
                        $temp = $obj_MemberLanguage->get_items_by_member_id($result_MemberLoginMethod['MemberLoginMethod']['member_id']);
                        foreach ($temp as $lang) {
                            $lang['MemberLanguage']['name'] = $display_name_column;
                            $data_MemberLanguage[] = $lang['MemberLanguage'];
                        }

                        // check group exist?
                        $conditions = array(
                            'MembersGroup.member_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                            'MembersGroup.school_id' => $school_id,
                            'MembersGroup.role_id'   => $role_id,
                            'MembersGroup.group_id'  => $group_id,
                            'MembersGroup.enabled'   => true,
                        );
                        if (!$obj_MembersGroup->get_obj_with_conditions($conditions)) {   //  member group don't exist? => add new group
                            $data_MembersGroup[] = array(
                                'member_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                                'school_id' => $school_id,
                                'role_id'   => $role_id,
                                'group_id'  => $group_id,
                            );
                            $add_new_group = true;
                            goto add_data;
                        }

                        $edit_flag = true;
                        goto add_data;

                    } else {
                        $result[] = $val;
                        goto add_data;
                    }

                } else {        // exist email in system => UPDATE member, member login method,  

                    $data_Member[] = array(
                        'id'                    => $result_Member['Member']['id'],
                        'email'                 => $email_column,
                        'verified'              => true,
                        'phone_number'          => $phone_number_column,
                    );

                    $conditions = array(
                        'MemberLoginMethod.username' 		=> $username_column,
                        'MemberLoginMethod.member_id' 		=> $result_Member['Member']['id'],
                        'MemberLoginMethod.school_id'       => $school_id,
                    );
                    if ($result_MemberLoginMethod = $obj_MemberLoginMethod->get_obj_with_conditions($conditions)) {   // exist member login method , edit 
                        // check member role
                        $cond = array(
                            'MemberRole.school_id'  => $school_id,
                            'MemberRole.role_id'    => $role_id,
                            'MemberRole.member_id'  => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                        );
                      
                        if (!$obj_MemberRole->hasAny($cond)) {
                            $data_MemberRole[] = array(
                                'school_id'             => $school_id,
                                'role_id'               => $role_id,
                                'original_member_id'    => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                                'member_id'             => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                            );
                        }
                
                        $data_MemberLoginMethod[] = array(
                            'id'                            => $result_MemberLoginMethod['MemberLoginMethod']['id'],
                            'username'                      => $username_column,
                            'password'                      => $obj_Member->set_password($password_column),
                            'display_name'                  => $display_name_column,
                        );
        
                        // add member language
                        $temp = $obj_MemberLanguage->get_items_by_member_id($result_MemberLoginMethod['MemberLoginMethod']['member_id']);
                        foreach ($temp as $lang) {
                            $lang['MemberLanguage']['name'] = $display_name_column;
                            $data_MemberLanguage[] = $lang['MemberLanguage'];
                        }

                        // check group exist?
                        $conditions = array(
                            'MembersGroup.member_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                            'MembersGroup.school_id' => $school_id,
                            'MembersGroup.role_id'   => $role_id,
                            'MembersGroup.group_id'  => $group_id,
                            'MembersGroup.enabled'   => true,
                        );
                        if (!$obj_MembersGroup->get_obj_with_conditions($conditions)) {   //  member group don't exist? => add new group
                            $data_MembersGroup[] = array(
                                'member_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                                'school_id' => $school_id,
                                'role_id'   => $role_id,
                                'group_id'  => $group_id,
                            );
                            $add_new_group = true;
                            goto add_data;
                        }

                        $edit_flag = true;
                        goto add_data;
                    
                    } else {    // email found and username, school id not found -> show error message!!!
                        $cannot_edit_flag = true;
                        $total_errors[] = "Exist email in system but username: " .  $username_column . " and school id: " .  $school_id . " not found!!!";
                        goto add_data;

                    }
                }
            
            } else { // email don't input
                $conditions = array(
                    'MemberLoginMethod.username' 		=> $username_column,
                    'MemberLoginMethod.school_id'       => $school_id,
                );
                if ($result_MemberLoginMethod = $obj_MemberLoginMethod->get_obj_with_conditions($conditions)) { // member login method exist? => username, school id => update

                    $data_Member[] = array(
                        'id'                    => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                        'email'                 => $email_column,
                        'verified'              => true,
                        'phone_number'          => $phone_number_column,
                    );
                    // update member (email), member login method (password)
                    $data_MemberLoginMethod[] = array(
                        'id'                            => $result_MemberLoginMethod['MemberLoginMethod']['id'],
                        'username'                      => $username_column,
                        'password'                      => $obj_Member->set_password($password_column),
                        'display_name'                  => $display_name_column,
                    );

                    // check member role
                    $cond = array(
                        'MemberRole.school_id'  => $school_id,
                        'MemberRole.role_id'    => $role_id,
                        'MemberRole.member_id'  => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                    );
                  
                    if (!$obj_MemberRole->hasAny($cond)) {  // don't exist role -> add new
                        $data_MemberRole[] = array(
                            'school_id'             => $school_id,
                            'role_id'               => $role_id,
                            'original_member_id'    => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                            'member_id'             => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                        );
                    }

                    // add member language
                    $temp = $obj_MemberLanguage->get_items_by_member_id($result_MemberLoginMethod['MemberLoginMethod']['member_id']);
                    foreach ($temp as $lang) {
                        $lang['MemberLanguage']['name'] = $display_name_column;
                        $data_MemberLanguage[] = $lang['MemberLanguage'];
                    }

                    // check group exist?
                    $conditions = array(
                        'MembersGroup.member_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                        'MembersGroup.school_id' => $school_id,
                        'MembersGroup.role_id'   => $role_id,
                        'MembersGroup.group_id'  => $group_id,
                        'MembersGroup.enabled'   => true,
                    );
                    if (!$obj_MembersGroup->get_obj_with_conditions($conditions)) {   // don't exist -> add this member into this group
                        $data_MembersGroup[] = array(
                            'member_id' => $result_MemberLoginMethod['MemberLoginMethod']['member_id'],
                            'school_id' => $school_id,
                            'role_id'   => $role_id,
                            'group_id'  => $group_id,
                        );
                        $add_new_group = true;
                       
                    }
                    $edit_flag = true;

                } else {            // don't exist email, don't exist username, school id -> add new
                    $result[] = $val;
                }
            } 
            
            add_data:
            if ($wrong_format_flag) {
                $message = "Wrong import template!!!";
                $color = "red";
                goto return_data;
            } 

            if ($add_new_group) {
                $message = $message . "-Record " . $row . ": (". $username_column . ") Add to new Group!<br>";
                $row = $row + 1;
                continue;
            }

            if ($edit_flag) {   // true => exist edit 
                $message = $message . "-Record " . $row . ": (". $username_column . ") Update Info Succeed!<br>";
                $row = $row + 1;
                continue;
            }

            if (!$empty_flag && !$no_space_flag && !$cannot_edit_flag) {
                $message = $message . "-Record " . $row . ": (". $username_column . ") Import Succeed!<br>";

            } else {
                $message = $message . "-Record " . $row . ": (". $username_column . ") Cannot Import! Error: " . implode(", ", $total_errors) . "<br>";
                $color = "red";
            }

            $row = $row + 1;
        }

        return_data: 
        return array(
            'message'                   => $message, 
            'data'                      => $result,                             // list data need add to DB,
            'data_Member'               => $data_Member,          
            'data_MemberLoginMethod'    => $data_MemberLoginMethod,           
            'data_MemberLanguage'       => $data_MemberLanguage,              
            'data_MembersGroup'         => $data_MembersGroup,
            'data_MemberRole'           => $data_MemberRole,
            'color'                     => $color,
        );
    }
}
