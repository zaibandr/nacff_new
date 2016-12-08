@extends('default')
@section('content')
    <link href="{{asset('resources/assets/css/lpu.css')}}" rel="stylesheet">
    <div id="lpu">
        <h1>Интеграция ЛИС ООО НАКФФ со сторонними программами</h1>
        <div class="row">
            <div class="col-lg-12">
                <ol id="ol-help">
                    <li><a class="xx" href="#start"><b>Проткол доступа</b></a></li>
                    <li><a class="xx" href="#library"><b>Библиотека С++</b></a></li>
                    <li><a class="xx" href="#pool"><b>Пул номеров</b></a></li>
                    <li><a class="xx" href="#exampleCpp"><b>Пример использования библиотеки на С++</b></a></li>
                    <li><a class="xx" href="#exampleDelphi"><b>Пример использования библиотеки на Delphi</b></a></li>
                    <li><a class="xx" href="#1C"><b>Пример обработок для программы 1C</b></a></li>
                    <li><a class="xx" href="#download"><b>Скачать</b></a></li>
                </ol>

                <h1 id="start" style="padding-top: 0px; background-color:#C8ECF0; padding-left: 15px; font-size: 14px; color: #555555;">Протокол доступа</h1>
                <p>Лаборатория ООО НАКФФ предоставляет доступ для своих клиентов к автоматической системе регистрации направлений, отслеживания их статуса и получения результатов на базе протокола доступа. Актуальная версия протокола находится по адресу: <a href="/api.pdf">https://nacpp.info/api.pdf</a>. В этом документе подробно описаны последовательности обмена сообщения для осуществления всех бизнес-процессов по взаимодействию лабораторной информационной системы ООО НАКФФ со сторонними программными решениями. </p>
                <p> Основу протокола составляет передача сообщений в формате XML по шифрованному каналу связи HTTPS. Для упрощения разработки программ по интеграции IT-отдел лаборатории предоставляет библиотеку, написанную на С++, которая инкапсулирует сложности организации и управления сессиями.</p>

                <h1 id="library" style="padding-top: 0px; background-color:#C8ECF0; padding-left: 15px; font-size: 14px; color: #555555;">Библиотека доступа</h1>

                <p>Основу библиотеки доступа предоставляет интерфейсный класс:</p>

<pre class='brush: js;'>
class NacppInterface
{
public:
    /**
    @brief Получение справочника.
    @detailed Данная функция позволяет получить требуемый справочник.
    @param dict Тип справочника:
        * bio - биоматериалы;
        * tests - тесты и аналиты;
        * containertypes - типы контейнеров;
        * panels - панели испытаний.
    @param isError Сохраняет код ошибки, 0 - если ошибок нет.
    @return XML-сообщение с требуемым справочником.
    */
    virtual char* GetDictionary(LPCSTR dict, int* isError) = 0;

    /**
    @brief Получение пула номеров направлений.
    @detailed Данная функция сформирует свободные номера
    для правильного штрихкодирования проб в медицинском центре.
    @param num Количество направлений для передачи (не более 1000)
    @param isError Сохраняет код ошибки, 0 - если ошибок нет.
    @return XML-сообщение с требуемым числом свободных номеров направлений.
    */
    virtual char* GetFreeOrders(int num, int* isError) = 0;

    /**
    @brief Регистрация нового направления.
    @detailed Данная функция позволяет получить требуемый справочник.
    @param message XML-файл, описывающий демографию пациента.
    @param isError Сохраняет код ошибки, 0 - если ошибок нет.
    @return XML-сообщение с ответом:
    В случае успеха будет передан сгенерированный номер направления,
    атрибут “статус” будет установлен в OK, в противном случае – в
    FAILED и в комментарии будет написана причина отказа в регистрации.
    */
    virtual char* CreateOrder(const char* message, int* isError) = 0;

    /**
    @brief Редактирование существующего направления.
    @detailed Данная функция позволяет редактировать направление
    после его регистрации. Редактирование возможно до тех пор, пока пробы
    не поступят в лабораторию. С этого момента любые изменения
    в направлении должны согласовываться с лабораторией напрямую.
    @param message XML-файл, описывающий демографию пациента, с изменениями.
    @param isError Сохраняет код ошибки, 0 - если ошибок нет.
    @return XML-сообщение с ответом:
    В случае успеха атрибут “статус” будет установлен в OK, в противном
    случае – в FAILED и в комментарии будет написана причина отказа в регистрации.
    */
    virtual char* EditOrder(const char* message, int* isError) = 0;

    /**
    @brief Исключение направления.
    @detailed Данная функция позволяет исключать целиком направление.
    @param folderno Номер направления.
    @param isError Сохраняет код ошибки, 0 - если ошибок нет.
    @return XML-сообщение с ответом:
    В случае успеха атрибут “статус” будет установлен в OK, в противном
    случае – в FAILED и в комментарии будет написана причина отказа в регистрации.
    */
    virtual char* DeleteOrder(const char* folderno, int* isError) = 0;

    /**
    @brief Получение результатов.
    @detailed Данная функция позволяет получить результат
    по заданному направлению.
    @param folderno Номер направления.
    @param isError Сохраняет код ошибки, 0 - если ошибок нет.
    @return XML-сообщение с результатами исследований.
    */
    virtual char* GetResults(const char* folderno, int* isError) = 0;

    /**
    @brief Получение списка ожидающих передачи направлений.
    @detailed Данная функция позволяет получить список.
    ожидающих передачи направлений.
    @param isError Сохраняет код ошибки, 0 - если ошибок нет.
    @return XML-сообщение с номерами проб, регистрация которых
    совершилась менее месяца назад от текущей даты и которые
    не были переданы в МИС.
    */
    virtual char* GetPending(int* isError) = 0;

    /**
    @brief Печатная версия PDF с результатами исследований по направлению.
    @detailed Данная функция позволяет получить печатную версию PDF
    с результатами исследований по заданному направлению.
    @param folderno Номер направления.
    @param filePath Путь сохранения файла.
    @return Код ошибки, 0 - если ошибок нет.
    */
    virtual int GetPrintResult(const char* folderno, LPCWSTR filePath = L"") = 0;

/**
    @brief Переподключение к сервису в случае обрыва связи или
    первышения допустимого количества запросов в рамках одного соединения
    */
    virtual void Reconnect(int *isError) = 0;

    /*закрытие сессии и удаление объекта */
    virtual void Logout() = 0;

    /* Пополнение кэша свободных номеров */
    virtual void CacheOrders(int *isError) = 0;

    /* получение следующего номера из кэша */
    virtual char * GetNextOrder(int *isError) = 0;

    /* очистка динамической памяти */
    virtual void FreeString(char *)=0;

    virtual ~NacppInterface() {}
};

extern "C"
{
    NacppInterface * DLLEXPORT login(const char * login, const char * password, int *isError);
    char * DLLEXPORT GetDictionary(NacppInterface *nacpp, const char* dict, int* isError);
    char * DLLEXPORT GetFreeOrders(NacppInterface *nacpp, int num, int* isError);
    char * DLLEXPORT GetResults(NacppInterface *nacpp, const char* folderno, int* isError);
    char * DLLEXPORT GetPending(NacppInterface *nacpp, int* isError);
    char * DLLEXPORT CreateOrder(NacppInterface *nacpp, const char* message, int* isError);
    char * DLLEXPORT DeleteOrder(NacppInterface *nacpp, const char* folderno, int* isError);
    char * DLLEXPORT EditOrder(NacppInterface *nacpp, const char* message, int* isError);
    int DLLEXPORT GetPrintResult(NacppInterface *nacpp, const char* folderno, const char * filePath);
    void DLLEXPORT logout(NacppInterface *nacpp);
    void DLLEXPORT reconnect(NacppInterface *nacpp,int *isError);
    void DLLEXPORT FreeString(char * buf);
    char * DLLEXPORT GetNextOrder(NacppInterface *nacpp, int *isError);
}

</pre>

                <p> При использовании на языках С/С++ можно создать экземляр класса и пользоваться его методами: </p>

<pre class='brush: js;'>

extern "C" __declspec(dllexport)
NacppInterface * getTransport(const char* login,
                              const char* password,
                              int  * isError)
{
    return new NacppTransport(login, password, isError);
}

</pre>

                <p> Пароль и логин следует получать через службу клиентской поддержки лаборатории НАКФФ. </p>

                <h1 id="pool" style="padding-top: 0px; background-color:#C8ECF0; padding-left: 15px; font-size: 14px; color: #555555;">Механизм получения свободных номеров</h1>

                <p> Для получения пула свободных номеров в протоколе используется метод GetFreeOrders, причем за один раз нельзя получить более 500 номеров. В библиотеке реализовано кеширование номеров в базе SQLite3. Отдельный поток мониторит количество номеров в кеше, если оно становится ниже минимального (50), то запрашивается сервис ООО НАКФФ для получения дополнительной порции в размере 100 штук. Метод GetNextOrder бибилиотеки возвращает следующий номер, взятый либо из кеша, либо непосредственно с сервиса. Возвращается строка размером 10 символов, содержащая свободный номер лаборатории. </p>


                <h1 id="exampleCpp" style="padding-top: 0px; background-color:#C8ECF0; padding-left: 15px; font-size: 14px; color: #555555;">Пример использования библиотеки на С++</h1>

                <p> Ниже представлен полноценный пример использования функций библиотеки на языке С++. </p>
<pre class='brush: js;'>
typedef NacppInterface* (*TRANSPORT_FACTORY)(const char*, const char*, int *);

#ifdef WIN32
HINSTANCE hModule;
#else
void * hModule;
#endif

//Загрузка динамической библиотеки
TRANSPORT_FACTORY LoadLisCom()
{
    TRANSPORT_FACTORY p_factory_function;
#ifdef WIN32
    hModule= LoadLibrary("libLisCom.dll");
    if (hModule)
        p_factory_function =
            (TRANSPORT_FACTORY)GetProcAddress(hModule, "getTransport");
#else
    hModule = dlopen("liscom/libLisCom.so", RTLD_LAZY);
    if (hModule)
    {
        dlerror();
        p_factory_function = (TRANSPORT_FACTORY) dlsym(hModule, "getTransport");
    }
#endif
    return p_factory_function;
}

//выгрузка динамической библиотеки
void UnloadLisCom()
{
#ifdef WIN32
    FreeLibrary(hModule);
#else
    dlclose(hModule);
#endif
}

//макрос только для упрощения кода
//проверяет код возвращения метода сервиса и в случае успеха печатает сообщение,
//все методы возвращают char *, удаление строк лежит на сороне клиента.

#define print(str) if(res == ERROR_NO) { std::cout << str << std::endl; \\
		    std::cout.flush(); nacpp->FreeString(str); }else std::cout \\
                    << "ErrorCode: " << res << std::endl

int main ()
{
    NacppInterface * nacpp = NULL;
    TRANSPORT_FACTORY p_factory_function = LoadLisCom();
    if (p_factory_function != NULL)
    {
        //!!! Внимание. Это тестовый аккаунт. Для тестирования используйте логин и пароль,
        //полученный от менеджеров лаборатории.


        const char * login = "YOURLOGIN";
        const char * password = "YOURPASSWORD";

        int res;
        nacpp = (*p_factory_function)(login, password, &res);

        if(res != 0)
        {
            //Ошибки здесь сетевые: недоступен хост, неверно загружены SSL библиотеки и пр.
            fprintf(stderr, "Error in authorization/communication: %d.\n", res);

            delete nacpp;
            UnloadLisCom();

            return EXIT_FAILURE;
        }

        //получение справочников
        char * dict = nacpp->GetDictionary("bio", &res);
        print(dict);

	nacpp->Logout();
    }

    UnloadLisCom();
    return EXIT_SUCCESS;

}

</pre>

                <p> Общий алгоритм использования библиотеки состоит из нескольких шагов: </p>
                <ul>
                    <li> загрузка динамической библиотеки </li>
                    <li> создание класса; при этом будет автоматически устанавливаться сессия с сервисом лаборатории </li>
                    <li> выполнение различный запросов к сервису на основе протокола, получение результатов и обязательное удаление их из динамической памяти при помощи метода FreeString(char *)</li>
                    <li> удаление экземпляра класса (метод Logout) и выгрузка библиотеки; при этом автоматически произойдет удаление пользовательской сессии. </li>
                </ul>

                <h1 id="exampleDelphi" style="padding-top: 0px; background-color:#C8ECF0; padding-left: 15px; font-size: 14px; color: #555555;">Пример на Delphi</h1>


                <p> На языках отличных от С/С++ рекомендуется использовать функциональный интерфейс класса. При желании можно подлкючить класс к любому языку через связку SWIG.</p>

                <p>Интерфейсный модуль для подключения библиотеки:</p>

<pre class='brush: js;'>

unit LisCom;

interface

const

  ERROR_NO = 0;
  ERROR_COMMUNICATION = 100;
  ERROR_TOO_BIG_MESSAGE = 101;
  ERROR_HTTP_PARSER = 102;
  ERROR_LOGIN = 103;
  ERROR_SSLCONTEXT = 104;
  ERROR_SOCKET = 105;
  ERROR_SSLHANDLE = 106;
  ERROR_SSLSETFD = 107;
  ERROR_SSLCONNECT = 108;
  ERROR_UNKNOWN_DICT = 200;
  ERROR_MORE_POOL_NUM = 201;
  ERROR_PDF_GENERATION = 300;
  ERROR_PDF_CHECK_SUM = 301;
  ERROR_PDF_FILE_CREATE = 302;

type

  LPCSTR = PAnsiChar;

  NacppInterface = THandle;

  function login(user: PAnsiChar; password: PAnsiChar; var isError: Integer): NacppInterface; cdecl;
  function GetDictionary(nacpp: NacppInterface; dict: PAnsiChar; var isError: Integer): PAnsiChar; cdecl;
  function GetFreeOrders(nacpp: NacppInterface; num: Integer; var isError: Integer): PAnsiChar; cdecl;
  function GetResults(nacpp: NacppInterface; folderno: PAnsiChar; var isError: Integer): PAnsiChar; cdecl;
  function GetPending(nacpp: NacppInterface; var isError: Integer): PAnsichar; cdecl;
  function CreateOrder(nacpp: NacppInterface; message: PAnsiChar; var isError: Integer): PAnsiChar; cdecl;
  function DeleteOrder(nacpp: NacppInterface; folderno: PAnsiChar; var isError: Integer): PAnsiChar; cdecl;
  function EditOrder(nacpp: NacppInterface; message: PAnsiChar; var isError: Integer): PAnsiChar; cdecl;
  function GetPrintResult(nacpp: NacppInterface; folderno: PAnsiChar;  filePath: PAnsiChar): Integer; cdecl;
  procedure logout(nacpp: NacppInterface ); cdecl;
  procedure reconnect(nacpp: NacppInterface; var isError: Integer); cdecl;
  procedure FreeString(buf: PAnsiChar); cdecl;

implementation

const
  LisComDll = 'libLiscom.dll';

  function GetDictionary; external LisComDll;
  function GetFreeOrders; external LisComDll;
  function GetResults; external LisComDll;
  function GetPending; external LisComDll;
  function CreateOrder; external LisComDll;
  function DeleteOrder; external LisComDll;
  function EditOrder; external LisComDll;
  function GetPrintResult; external LisComDll;
  procedure logout; external LisComDll;
  procedure reconnect; external LisComDll;
  procedure FreeString; external LisComDll;
  function login; external LisComDll

end.

</pre>

                <p>Пример использования:</p>

<pre class='brush: js;'>

procedure GetbioDictionary
var
  err: Integer;
  nacpp: NacppInterface;
  res: PAnsiChar;
  resd: AnsiString;
begin
  nacpp := login('TEST', 'TEST', err);
  if(err = ERROR_NO) then
  begin
        try
           res := GetDictionary(nacpp, 'bio', err);
           resd:= res;
           FreeString(res);

           if(err = ERROR_NO) then
           begin
              //обрабатываем сообщение.
           end;

        finally

        end;
  end;
  logout(nacpp);
end;


</pre>
                <h1 id="download" style="padding-top: 0px; background-color:#C8ECF0; padding-left: 15px; font-size: 14px; color: #555555;">Скачать</h1>

                <p> Исходники самой библиотеки распространяются бесплатно и доступны по адресу: <a href="https://github.com/carpovpv/LisCom">https://github.com/carpovpv/LisCom</a></p><p>  Откомпилированную версию библиотеки для платформы Win32 можно скачть здесь: <a href="https://github.com/carpovpv/LisCom/releases">https://github.com/carpovpv/LisCom/releases</a> В файле main.cpp предоставлен пример работы с библиотекой</p>
                <p> Также, скачать пример использования интеграции на языке PHP, вы можете <a href="./php-examples.zip"><b>здесь</b></a> (ZIP, 1Kb)

                <h1 id="1C" style="padding-top: 0px; background-color:#C8ECF0; padding-left: 15px; font-size: 14px; color: #555555;">Пример обработок для программ 1C</h1>

                <p>Перечень процедур, необходимых для организации интеграционных процессов с ЛИМС ООО «НАКФФ»: </p>

<pre class='brush: js;'>

// <Описание процедуры>
        // Процедура предназначена для организации подключения к  интеграционному сервису
        // лаборатории ООО "НАКФФ"

        Процедура Подключиться()

        Прокси=Новый ИнтернетПрокси(Ложь);
        Прокси.НеИспользоватьПроксиДляАдресов.Добавить(адрес.Сервер);

        ssl_ = Новый ЗащищенноеСоединениеOpenSSL(неопределено, неопределено);
        НАКФФ_Коннект = Новый HTTPСоединение(Адрес.Сервер,Адрес.Порт,Адрес.Пользователь,Адрес.Пароль,Прокси,0,ssl_);

        Если НАКФФ_Коннект=Неопределено Тогда
        Сообщить("Не удалось установить подключение к серверу!");
        Возврат;
        КонецЕсли;

        ВхИмя   = ПолучитьИмяВременногоФайла();
        ВыхИмя  = ПолучитьИмяВременногоФайла();

        ЗаголовокHTTP = Новый Соответствие();
        ЗаголовокHTTP.Вставить("Content-Type", "application/x-www-form-urlencoded");
        ЗаголовокHTTP.Вставить("Accept-Language", "ru");
        ЗаголовокHTTP.Вставить("Accept-Charset", "utf-8");
        ЗаголовокHTTP.Вставить("Content-Language", "ru");
        ЗаголовокHTTP.Вставить("Content-Charset", "utf-8");
        ЗаголовокHTTP.Вставить("Content-Charset", "utf-8");

        Текст   = Новый ЗаписьТекста(ВхИмя,КодировкаТекста.ANSI);
        Пост    = "login=" + СокрЛП(Адрес.Пользователь) + "&password=" + СокрЛП(Адрес.Пароль);
        Текст.Записать(Пост);
        Текст.Закрыть();

        Попытка
        НАКФФ_Коннект.ОтправитьДляОбработки(ВхИмя,"/login2.php/",ВыхИмя,ЗаголовокHTTP);
        Исключение
        Сообщить(ИнформацияОбОшибке().Описание, СтатусСообщения.Важное);
        КонецПопытки;

        т   = Новый ТекстовыйДокумент();
        т.Прочитать(ВыхИмя, КодировкаТекста.UTF8);

        ID_ = СокрЛП(т.ПолучитьТекст());
        УдалитьФайлы(ВхИмя);

        УдалитьФайлы(ВыхИмя);

        ЗаголовокHTTP.Вставить("Cookie", "PHPSESSID=" + ID_);

        КонецПроцедуры // Подключиться()


</pre>

                <p> Спасибо за проявленный интерес к проекту интеграции!

                    По всем техническим вопросам обращайтес к Карпову Павлу (контактная информация указана на странице GitHub).</p>
            </div>
        </div>
    </div>
@stop