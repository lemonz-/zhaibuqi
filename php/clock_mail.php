<?php
//ignore_user_abort(); //即使Client断开(如关掉浏览器)，PHP脚本也可以继续执行.
//set_time_limit(0); // 执行时间为无限制，php默认的执行时间是30秒，通过set_time_limit(0)可以让程序无限制的执行下去
//$interval=60*5; // 每隔半天运行
//do{

    require_once('util.php');
    $dbc = mysqli_connect(host, user, password, database)
        or die("fail to connect");
    $query = "select * from user ";
    $data= mysqli_query($dbc,$query);
    while($row = mysqli_fetch_array($data)){
        $login_time = $row['login_time'];
        $userName = $row['nickname'];
        $email = $row['email'];
        $space_time = $row['space_time'];
//        $encrypt_email =md5($email);
        $String = base64_encode($email);
        if($space_time!=0){//如果用户需要提醒
        $present_time = date('Y-m-d H:i:s',time());//当前时间
            if((strtotime($present_time)-strtotime($login_time))>(60*60*24*$space_time)){//时间如果相差一周就发邮件给用户60*60*24*$space_time

                require_once('class.phpmailer.php'); //文件必须放在该文件所在目录

                $mail = new PHPMailer(); //建立邮件发送类
                $address =$email;

                $mail->IsSMTP(); // 使用SMTP方式发送

                $mail->Host = "smtp.qq.com"; // 您的企业邮局域名

                $mail->SMTPAuth = true; // 启用SMTP验证功能

                $mail->Username = "541232834@qq.com"; // 邮局用户名(请填写完整的email地址)

                $mail->Password = "8327ZHE782yi"; // 邮局密码

                $mail->Port=25;

                $mail->From = "541232834@qq.com"; //邮件发送者email地址

                $mail->FromName = "浪客剑心";

                $mail->AddAddress("$address", $userName);//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")

        //$mail->AddReplyTo("", "");

        //$mail->AddAttachment("/var/tmp/file.tar.gz"); // 添加附件

        $mail->IsHTML(true); // set email format to HTML //是否使用HTML格式

                $mail->Subject = "来自宅不起的提醒";//主题

                $mail->Body = '<html>
                    <head><meta charset="UTF-8"><title>宅不起 | 推荐提醒</title></head>
                    <body>
                        <table style="background:#ffffff;padding:0;border:0;width:100%;text-align:left;border-collapse:collapse;border-spacing:0;">
                            <tbody style="background:#ffffff;text-align:left;font-size:14px;color:#000000;font-family:Tahoma;line-height:19px;vertical-align:middle;width:99%;">
                                <tr><td>尊敬的&nbsp;<span style="font-weight:bold;">'.$userName.'</span>&nbsp;先生/女士，您好:</td></tr>
                                <tr><td><br /></td></tr>
                                <tr><td>好久不见，&nbsp;<a style="color:#84C43C;text-decoration:none;" href="http://www.zhaibuqi.com"><span>宅不起(www.zhaibuqi.com)</span></a>&nbsp;上有一些很多人都感兴趣的内容。也许您会喜欢，所以试着推荐给您，欢迎回来！</td></tr>
                                <tr><td><br /></td></tr>
                                <tr><td>您使用了本站提供的定时功能，您已经有一周未登录宅不起小站,本小站有.....精彩内容</td></tr>
                                <tr><td><br /></td></tr>
                                <tr><td>收到这封邮件是因为您有段时间没来了，它并不会频繁的骚扰您。如果仍觉得被打扰，请点击&nbsp;<a style="color:#888888;text-decoration:none;" href="http://localhost/zhaibuqi/zhaibuqi/php/unsubscribe.php?p=.$String">退订</a>&nbsp;。</td></tr>
                                <tr><td><br /></td></tr>
                                <tr><td>感谢对宅不起的支持，再次希望您在宅不起的体验有益和愉快！</td></tr>
                                <tr><td style="font-size:12px;">(这是一封自动产生的email，请勿回复)</td></tr>
                                <tr><td><br /></td></tr>
                                <tr><td><br /></td></tr>
                            </tbody>
                        </table>
                        <hr />
                        <div style="background:#ffffff;text-align:left;font-size:14px;color:#000000;font-family:Tahoma;line-height:19px;vertical-align:middle;width:99%;"><a style="color:grey;text-decoration:none;" href="http://www.zhaibuqi.com/" >宅不起 http://www.zhaibuqi.com/</a></div>
                    </body>
                </html>'; //邮件内容


                $mail->AltBody = "This is the body in plain text for non-HTML mail clients"; //附加信息，可以省略

                if(!$mail->Send())

                {

                    echo "邮件发送失败. <p>";

                    echo "错误原因: " . $mail->ErrorInfo;

                    exit;

                }

            }

        }
        }

//        $fp = fopen('test.txt','a');
//        fwrite($fp,'test');
//        fclose($fp);
//        sleep($interval); // 等待5分钟
//}while(true);

?>
