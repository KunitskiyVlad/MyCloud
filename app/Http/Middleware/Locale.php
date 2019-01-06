<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Request;
use Session;
class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public static $mainLanguage = 'en'; //основной язык, который не должен отображаться в URl

    public static $languages = ['en', 'ru']; // Указываем, какие языки будем использовать в приложении.
    public static function getLocale()
    {
        $raw_locale = Session::get('locale');     # Если пользователь уже был на нашем сайте,
        # то в сессии будет значение выбранного им языка.

      //  if (in_array($raw_locale, self::$languages)) {  # Проверяем, что у пользователя в сессии установлен доступный язык
      //      return $raw_locale;                                # (а не какая-нибудь бяка)
      //  }                                                         # И присваиваем значение переменной $locale.
       // else {
         //   return self::$mainLanguage;
        //}                 # В ином случае присваиваем ей язык по умолчанию

        //App::setLocale($locale);
        $uri = Request::path(); //получаем URI


        $segmentsURI = explode('/',$uri); //делим на части по разделителю "/"


        //Проверяем метку языка  - есть ли она среди доступных языков
        if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], self::$languages)) {

            if ($segmentsURI[0] != self::$mainLanguage) return $segmentsURI[0];

        }
        return self::$mainLanguage;
    }
    public function handle($request, Closure $next)
    {

        $locale = self::getLocale();

        if ($locale)
        {
            Session::put('locale',$locale);
            App::setLocale($locale);
        }
        //если метки нет - устанавливаем основной язык $mainLanguage
        else
            {
                Session::put('locale',self::$mainLanguage);
            App::setLocale(self::$mainLanguage);
        }

        return $next($request); //пропускаем дальше - передаем в следующий посредник
    }
}
