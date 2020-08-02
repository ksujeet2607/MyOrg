<?php   

    $this->Obj = new PHPMailer;

    $this->Obj->isSendmail();

    $this->Obj->isSMTP();

    $this->Obj->SMTPDebug = SMTP_DEBUG;

    $this->Obj->Host = SMTP_HOST;

    $this->Obj->SMTPAuth = true;

    $this->Obj->Username = EMAIL_FROM1;

    $this->Obj->Password = EMAIL_PASS1;

    $this->Obj->SMTPSecure = SMTP_SECURE;

    $this->Obj->Port = SMTP_PORT;

    $this->Obj->From = EMAIL_FROM;

    $this->Obj->FromName = SITE_NAME;

    $this->Obj->addReplyTo(EMAIL_FROM, SITE_NAME);

    $this->Obj->isHTML(true);

    
    ?>