<?php

class Mail {
    //put your code here
    protected $Obj;
    use General, Session;

    function __construct() {

        require('plugins/PHPMailer-master/PHPMailerAutoload.php');

        $this->Obj = new PHPMailer;

        $this->Obj->isSendmail();

        $this->Obj->isSMTP();

        $this->Obj->SMTPDebug = 0;

        $this->Obj->Host = SMTP_HOST;

        $this->Obj->SMTPAuth = true;

//        $this->Obj->Username = parent::getSiteInfo('Mailer Email');
//        $this->Obj->Password = parent::getSiteInfo('Mailer Password');
        $this->Obj->Username = EMAIL_FROM1;

        $this->Obj->Password = EMAIL_PASS1;

        $this->Obj->SMTPSecure = SMTP_SECURE;

        $this->Obj->Port = SMTP_PORT;

        $this->Obj->From = EMAIL_FROM;

        $this->Obj->FromName = SITE_NAME;

        $this->Obj->addReplyTo(EMAIL_FROM, SITE_NAME);

        $this->Obj->isHTML(true);
    }

    public function forgotPass($uid){
        $rs = $this->db_executeReader("profile", "mobile,email,password","LoginID = '$uid'","",false);
        $data = $this->db_read($rs);
        $to = $data['email'];
        $mobile = $data['mobile'];
        $password = $data['password'];
        $from = EMAIL_FROM;
        $msg = "Thank You, Your Login Password on ".SITE_NAME." is : ".$password.".";
        parent::send_sms($mobile, $msg);
        $message='<table border="0" cellspacing="0" cellpadding="0" bgcolor="#e8e8e8" style="max-width:700px;border-collapse:collapse;border:1px solid #e2e0e0;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#3a3a3a;line-height:18px" align="center">';
        $message.='<tbody><tr><td width="700px" valign="top" align="center"><table width="93%" border="0" align="center" cellpadding="0" cellspacing="0"><tbody><tr><td height="22"></td></tr><tr><td valign="top" align="center" bgcolor="#FFFFFF" style="border-radius:13px;">';
        $message.='<table width="93%" border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse"><tbody><tr><td height="25"></td></tr><tr><td valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse"><tbody>';
        $message.='<tr><td width="380" ><img src="'.SRC_URL.'img/logo@2x.jpg" alt="'. SITE_NAME.'" style="text-align:left;font-size:17px;font-style:italic;color:#ff3414" class="CToWUd"><span style="color: #ff3414;font-size:large;position: absolute;margin-left: 7px;">'.SITE_NAME.'</span></td></tr><tr><td ></td></tr>';
        $message.='<tr><td height="10"></td></tr></tbody></table></td></tr><tr><td height="22"></td></tr>'
                . '<tr><td><p style="margin-left: 12px;"><b>Dear </b> Member, Your Login Password is : '.$password.' </p></td></tr>'
                . '<tr><td height="10"></td></tr>'
                . '<tr><td><p style="margin-left: 12px;"></p></td></tr>';
        $message.='<tr><td height="10"></td></tr></tbody></table></td></tr>';
        $message.='<tr><td height="18"><center><br><font color="#999999" size="1">This is a computer auto generated message. Please do not Reply.<br>For any assistance please call on Ph: '. CONTACT_NO.'.</font><br><br></center></td></tr>';
        $message.='</tbody></table></td></tr></tbody></table>';
        $this->Obj->Subject = "Forgot Password  from " . SITE_NAME;
        $this->Obj->Body = $message;
        $this->Obj->addAddress($to, SITE_NAME);
        $this->Obj->send();
        return true;

    }

    public function savefeedback($data){
        $from = strtolower($data['email']);
        $mobile = $data['mobile'];
        $msg = $data['msg'];
        $name = $this->ucf($data['fname']);
        //$to = EMAIL_FROM;
        $to = EMAIL_FROM;
        $message='<table border="0" cellspacing="0" cellpadding="0" bgcolor="#e8e8e8" style="max-width:700px;border-collapse:collapse;border:1px solid #e2e0e0;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#3a3a3a;line-height:18px" align="center">';
        $message.='<tbody><tr><td width="700px" valign="top" align="center"><table width="93%" border="0" align="center" cellpadding="0" cellspacing="0"><tbody><tr><td height="22"></td></tr><tr><td valign="top" align="center" bgcolor="#FFFFFF" style="border-radius:13px;">';
        $message.='<table width="93%" border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse"><tbody><tr><td height="25"></td></tr><tr><td valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse"><tbody>';
        $message.='<tr><td width="380" ><img style="width:100%" src="'.SRC_URL.'img/logo@2x.jpg" alt="'. SITE_NAME.'" style="text-align:left;font-size:17px;font-style:italic;color:#ff3414" class="CToWUd"></td></tr><tr><td ></td></tr>';
        $message.='<tr><td height="10"></td></tr></tbody></table></td></tr><tr><td height="22"></td></tr>'
                . '<tr><td>'
                . '<p style="margin-left: 12px;">'
                . '<b>An feedback has been received on '.SITE_NAME.'.</p>'
                . '<p style="margin-left: 12px;">Feedback Detail: </p>'
                . '<p style="margin-left: 12px;"><b>Name </b>:'.$name.' </p>'
                . '<p style="margin-left: 12px;"><b>Mobile </b>:'.$mobile.' </p>'
                . '<p style="margin-left: 12px;"><b>Email </b>:'.$from.' </p>'
                . '<p style="margin-left: 12px;"><b>Message </b>:'.$msg.' </p>'
                . '</td></tr>'
                . '<tr><td height="10"></td></tr>'
                . '<tr><td><p style="margin-left: 12px;"></p></td></tr>';
        $message.='<tr><td height="10"></td></tr></tbody></table></td></tr>';
        $message.='</tbody></table>';

        $this->Obj->Subject = "Feedback on " . SITE_NAME;
        $this->Obj->Body = $message;
        $this->Obj->addAddress($to, SITE_NAME);
        $this->Obj->send();
        // die();
        return true;

    }

    public function saveEnquiry($data){
        $from = strtolower($data['email']);
        $mobile = $data['mobile'];
        $subject = $data['subject'];
        $msg = $data['msg'];
        $name = $this->ucf($data['fname']);
        //$to = EMAIL_FROM;
        $to = EMAIL_FROM;
        $message='<table border="0" cellspacing="0" cellpadding="0" bgcolor="#e8e8e8" style="max-width:700px;border-collapse:collapse;border:1px solid #e2e0e0;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#3a3a3a;line-height:18px" align="center">';
        $message.='<tbody><tr><td width="700px" valign="top" align="center"><table width="93%" border="0" align="center" cellpadding="0" cellspacing="0"><tbody><tr><td height="22"></td></tr><tr><td valign="top" align="center" bgcolor="#FFFFFF" style="border-radius:13px;">';
        $message.='<table width="93%" border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse"><tbody><tr><td height="25"></td></tr><tr><td valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse"><tbody>';
        $message.='<tr><td width="380" ><img style="width:100%" src="'.SRC_URL.'img/logo@2x.jpg" alt="'. SITE_NAME.'" style="text-align:left;font-size:17px;font-style:italic;color:#ff3414" class="CToWUd"></td></tr><tr><td ></td></tr>';
        $message.='<tr><td height="10"></td></tr></tbody></table></td></tr><tr><td height="22"></td></tr>'
                . '<tr><td>'
                . '<p style="margin-left: 12px;">'
                . '<b>An enquiry has been received on '.SITE_NAME.'.</p>'
                . '<p style="margin-left: 12px;">'.$subject.': </p>'
                . '<p style="margin-left: 12px;"><b>Name </b>:'.$name.' </p>'
                . '<p style="margin-left: 12px;"><b>Mobile </b>:'.$mobile.' </p>'
                . '<p style="margin-left: 12px;"><b>Email </b>:'.$from.' </p>'
                . '<p style="margin-left: 12px;"><b>Message </b>:'.$msg.' </p>'
                . '</td></tr>'
                . '<tr><td height="10"></td></tr>'
                . '<tr><td><p style="margin-left: 12px;"></p></td></tr>';
        $message.='<tr><td height="10"></td></tr></tbody></table></td></tr>';
        $message.='</tbody></table>';

        $this->Obj->Subject = "Enquiry on " . SITE_NAME;
        $this->Obj->Body = $message;
        $this->Obj->addAddress($to, SITE_NAME);
        $this->Obj->send();
        // die();
        return true;

    }

    public function postResume($data){
        $from = strtolower($data['email']);
        $mobile = $data['mobile'];
        $msg = $data['msg'];
        $name = $this->ucf($data['fname']);
        $to = EMAIL_FROM;
        $message='<table border="0" cellspacing="0" cellpadding="0" bgcolor="#e8e8e8" style="max-width:700px;border-collapse:collapse;border:1px solid #e2e0e0;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#3a3a3a;line-height:18px" align="center">';
        $message.='<tbody><tr><td width="700px" valign="top" align="center"><table width="93%" border="0" align="center" cellpadding="0" cellspacing="0"><tbody><tr><td height="22"></td></tr><tr><td valign="top" align="center" bgcolor="#FFFFFF" style="border-radius:13px;">';
        $message.='<table width="93%" border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse"><tbody><tr><td height="25"></td></tr><tr><td valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse"><tbody>';
        $message.='<tr><td width="380" ><img style="width:100%" src="'.SRC_URL.'img/logo@2x.jpg" alt="'. SITE_NAME.'" style="text-align:left;font-size:17px;font-style:italic;color:#ff3414" class="CToWUd"></td></tr><tr><td ></td></tr>';
        $message.='<tr><td height="10"></td></tr></tbody></table></td></tr><tr><td height="22"></td></tr>'
                . '<tr><td>'
                . '<p style="margin-left: 12px;">'
                . '<b>A cv / resume has been posted on '.SITE_NAME.'.</p>'
                . '<p style="margin-left: 12px;"><b>Name </b>:'.$name.' </p>'
                . '<p style="margin-left: 12px;"><b>Mobile </b>:'.$mobile.' </p>'
                . '<p style="margin-left: 12px;"><b>Email </b>:'.$from.' </p>'
                . '<p style="margin-left: 12px;"><b>Message </b>:'.$msg.' </p>'
                . '</td></tr>'
                . '<tr><td height="10"></td></tr>'
                . '<tr><td><p style="margin-left: 12px;"></p></td></tr>';
        $message.='<tr><td height="10"></td></tr></tbody></table></td></tr>';
        $message.='</tbody></table>';

        $this->Obj->Subject = "A cv / resume on " . SITE_NAME;
        $this->Obj->Body = $message;
        $this->Obj->addAddress($to, SITE_NAME);
        $this->Obj->send();
        // die();
        return true;

    }

}
