<?php
echo 'started<br>';
$data = json_decode(file_get_contents('php://input'), TRUE);
//����� � ���� ��� ���������
//file_put_contents('file.txt', '$data: '.print_r($data, 1)."\n", FILE_APPEND);

if ($data != null) {
  $token = file_get_contents ('http://f1054446.xsph.ru');
  if ($token != null) {
    define('TOKEN', $token);
    $data = $data['callback_query'] ? $data['callback_query'] : $data['message'];
    $params=[
      'chat_id' => 760218395,
      'from_chat_id' => $data['chat']['id'],
      'message_id' => $data['message_id']
    ];
    $res = sendTelegram('forwardMessage', $params);
    echo 'sended<br>';
  }
}


/*switch ($message) {
    case '��':
        $method = 'sendMessage';
    $send_data = [
      'text' => '��� �� ������ ��������?',
      'reply_markup'  => [
        'resize_keyboard' => true,
        'keyboard' => [
            [
              ['text' => '������'],
              ['text' => '�����'],
            ],
            [
              ['text' => '���'],
              ['text' => '������'],
            ]
          ]
        ]
      ];
    break;
  case '���':
        $method = 'sendMessage';
    $send_data = ['text' => '��������� ���'];
    break;
  case '������':
        $method = 'sendMessage';
    $send_data = ['text' => '����� ������!'];
    break;
  case '�����':
        $method = 'sendMessage';
    $send_data = ['text' => '����� ������!'];
    break;
  case '���':
        $method = 'sendMessage';
    $send_data = ['text' => '����� ������!'];
    break;
  case '������':
        $method = 'sendMessage';
    $send_data = ['text' => '����� ������!'];
    break;
  default:
    $method = 'sendMessage';
    $send_data = [
      'text' => '�� ������ ������� �����?',
      'reply_markup'  => [
        'resize_keyboard' => true,
        'keyboard' => [
            [
              ['text' => '��'],
              ['text' => '���'],
            ]
          ]
        ]
      ];
}

$send_data['chat_id'] = $data['chat'] ['id'];

$res = sendTelegram($method, $send_data);*/




function sendTelegram($method, $data, $headers = [])
{
  $curl = curl_init();
  curl_setopt_array($curl, [
    CURLOPT_POST => 1,
    CURLOPT_HEADER => 0,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://api.telegram.org/bot' . TOKEN . '/' . $method,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"))
  ]);
  $result = curl_exec($curl);
  curl_close($curl);
  return (json_decode($result, 1) ? json_decode($result, 1) : $result);
}

?>