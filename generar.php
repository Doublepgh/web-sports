<?php 

$configargs = [
	'config' => "c:/xampp/php/extras/openssl/openssl.cnf",
	'private_key_bits'=>2048,
	'default_md' => "sha256"
];

$generar = openssl_pkey_new($configargs);
openssl_pkey_export($generar,$llavePrivada,NULL,$configargs);

$llavePublica = openssl_pkey_get_details($generar);

file_put_contents('private.key',$llavePrivada);
file_put_contents('public.key',$llavePublica['key']);

echo "las llaves se crearon correctamente";
