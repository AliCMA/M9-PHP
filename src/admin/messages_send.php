<?php 

require_once '../vendor/autoload.php';

require_once 'config.php';

use Symfony\Component\Mailer\Transport;

use Symfony\Component\Mailer\Mailer;

use Symfony\Component\Mime\Email;

$response = $db->loginRequired();

if (!$response) {

    header('Location: login.php');

    exit;

}

$title = "Send Message";

$id = (int) $_GET['id']; 

$tab = 'mess';

if(isset($_POST['submitted'])) {  

    $query = "SELECT * FROM subscribers WHERE id=0 "; 

    $emails = array(); 

    foreach($_POST['newsletter'] as $n) { 

        if($n['send'] == "true") { 

            $nlid = $n['nlid']; 

            $e = $db->query("SELECT subscriber_id FROM subscriptions WHERE newsletter_id=$nlid");

            foreach($e as $s) { 

                $sqlids .= " OR id=".$s['subscriber_id']; 

            } 

            $query .= $sqlids; 

        } 

    } 

    $subscribers = $db->query($query);

    foreach($subscribers as $sub) {

        $emails[$sub['email']] = $sub['name'];

    }

    $from = array(FROM_EMAIL => FROM_NAME);

    $mess = $db->query("SELECT * FROM messages WHERE id=$id");

    $message = $mess[0];

    $subject = $message['subject'];

    $tid = $message['template_id']; 

    $data = $db->query("SELECT body FROM templates WHERE id=$tid LIMIT 1");

    $template = $data[0]['body'];

    if($message['rightcol'] == '') {

        $leftcol = $message['leftcol'];

        $body = str_replace('%content%', $leftcol, $template);

    } else {

        $leftcol = $message['leftcol'];

        $rightcol = $message['rightcol'];

        $b = str_replace('%leftcol%', $leftcol, $template);

        $body = str_replace('%rightcol%', $rightcol, $b);

    }

    $transport = Transport::fromDsn('smtp://username:password@hostname:port');

    $mailer = new Mailer($transport); 

    $email = (new Email())

        ->from($from)

        ->to($emails)

        ->subject($subject)

        ->html($body);

    $mailer->send($email);

    header('Location: index.php');

} 

$newsletters = $db->query("SELECT * FROM newsletters");

foreach($newsletters as $nl) { 

    $nls .= '

<input type="hidden" name="newsletter['.$nl["id"].'][nlid]" value="'.$nl['id'].'" />

<input type="checkbox" name="newsletter['.$nl["id"].'][send]" value="true" '.$checked.'/>

<label for="newsletter['.$nl["id"].']">'.$nl['name'].'</label> - '.$nl['description'].'<br />

'; 

} 

$mess = $db->query("SELECT * FROM messages WHERE id=$id");

$message = $mess[0];

$subject = $message['subject'];

$content = '<a href="messages_preview.php?id='.$id.'" class="large" target="_new">preview »</a><br />

<form action="messages_send.php?id='.$id.'" method="POST">

<p>

Subject: '.$subject.'<br />

</p>


<p>Send to:<br />

'.$nls.'

</p>


<p>

<input type="submit" value="Send »" />

<input type="hidden" value="1" name="submitted" />

</p>

</form>';

include 'layout.php';

?>
