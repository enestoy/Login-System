<?php
session_start();
include 'fonksiyon/helper.php';



$user = [
    'enestoy' => [
        'password' => '123456',
        'mail' => 'eneskairos@gmail.com'
    ],
    'zeynepgul2' => [
        'password' => '1234',
        'mail' => 'info@zeynep.org'
    ]
];

//Giriş İşlemi Gerçekleşmişse
if(get('islem')=='giris'){

    $_SESSION['username'] = post('username');
    $_SESSION['password'] = post('password');



    if(!post('username')){

        $_SESSION['error'] = 'Lütfen Kullanıcı Adınızı Giriniz.';
        header('Location:login.php');
    }
    else if(!post('password')){
        $_SESSION['error'] = 'Lütfen Şifrenizi Giriniz.';
        header('Location:login.php');
    }
    else{

        if(array_key_exists(post('username'),$user)){

            if($user[post('username')]['password'] == post('password')){

                $_SESSION['login']=true;
                $_SESSION['kullanici_adi'] = post('username');
                $_SESSION['eposta'] = $user[post('username')]['mail'];
                header('Location:index.php');

            }
            else{
                $_SESSION['error']='Kullanıcı Adı veya Şifresi Hatalı.';
                header('Location:login.php');
            }
            
        }
        else{

            $_SESSION['error']='Böyle bir kullanıcı yoktur.';
            header('Location:login.php');
        }
    }
}


if(get('islem')=='hakkimda'){
    $hakkimda = post('hakkimda');
    $islem = file_put_contents('./db/'.session('kullanici_adi').'.txt',htmlspecialchars($hakkimda));
    if($islem){
        header('Location:index.php?islem=true');
    }else{
        header('Location:index.php?islem=false');
    }
    
}

if(get('islem')=='cikis'){
    session_destroy();
    session_start();
    $_SESSION['error'] = 'Oturum Sonlandırıldı.';
    header('Location:login.php');
}

if(get('islem')=='renk'){
    
    setcookie('color',get('color'),time()+(365*86400));
    
    header('Location:'.$_SERVER['HTTP_REFERER']??'index.php');

    //HTTP_REFERER buraya hangi sayfadan gelindiğini döndürür.
}


?>