/**

* json方式不支持GET方法

* @param $url

* @param $data

* @param array $header

* @param string $method

* @param string $type

* @return bool|string

*/

function curlData($url, $data, $header, $method = 'GET', $type='json')

{
//初始化

$ch = curl_init();

if ($type=='json') {
$headers = ['Content-Type: application/json; charset=utf-8'];

} elseif ($type=='form-urlencoded') {
$headers = ['Content-Type: application/x-www-form-urlencoded; charset=utf-8'];

}

//$headers=array_merge($headers, $header);

if ($method == 'GET' && $type!='json') {
if ($data) {
$querystring = http_build_query($data);

$url = $url.'?'.$querystring;

}

}

// 请求头，可以传数组

curl_setopt($ch, CURLOPT_URL, $url);

//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

curl_setopt($ch, CURLOPT_HEADER, false);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 执行后不直接打印出来

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

curl_setopt($ch, CURLOPT_AUTOREFERER, 1);

curl_setopt($ch, CURLOPT_REFERER, "http://www.baidu.com");

curl_setopt($ch, CURLOPT_TIMEOUT, 10);

if ($method == 'POST' && $type=='json') {
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'POST'); // 请求方式

curl_setopt($ch, CURLOPT_POST, 1); // post提交

curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // post的变量

} elseif ($method == 'POST' && $type!='json') {
curl_setopt($ch, CURLOPT_POST, 1); // post提交

$querystring = http_build_query($data);

curl_setopt($ch, CURLOPT_POSTFIELDS, $querystring); // post的变量

}

if ($method == 'PUT') {
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

}

if ($method == 'DELETE') {
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

}

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器

if (!empty($cookie)) {
curl_setopt($ch, CURLOPT_COOKIE, $cookie);

} //设置cookie

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 不从证书中检查SSL加密算法是否存在

$output = curl_exec($ch); //执行并获取HTML文档内容

$return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch); //释放curl句柄

return $output;

return array($return_code, $output);

// return $output;

}

$method =$_POST['hide-method'] ?? "GET";

$url =$_POST['hide-link'] ?? "";

$type = $_POST['body_type'] ?? 1;

$header_keys=$_POST['header_keys'] ?? '';

$header_values=$_POST['header_values'] ?? '';

$header=[];

//foreach ($header_keys as $k => $v) {
//if ($v) {
//$header[] ="$v: $header_values[$k]";

//}

//}

if (!empty($header_values)) {
$header=array_filter($header);

}

if ($type==1) {
$content_type='form-urlencoded';

$body_keys=$_POST['body_keys'] ?? '';

$body_values=$_POST['body_values'] ?? '';

//foreach ($body_keys as $key => $value) {
//$data[$value] =$body_values[$key];

//}

//$data=array_filter($data);

} elseif ($type==2) {
$content_type='json';

$data=$_POST['body_json'] ?? '';

}