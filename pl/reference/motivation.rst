Nasza motywacja
==============
Istnieje wiele frameworków PHP w dzisiejszych czasach, ale żaden z nich nie jest jak Phalcon (naprawdę, zaufaj nam i temu jednemu :) ).

Prawie wszyscy programiści wolą używać frameworka. Jest to przede wszystkim dlatego, że oferuje wiele funkcji, które są już przetestowane
i gotowe do użycia, a więc utrzymują kod DRY (nie powtarzający się). Jednak sam framework wymaga wielu inkluzji plików i setek linii kodu, które
mają być interpretowane i wykonywane na każde żądanie z aktualnej aplikacji. Frameworki zorientowane obiektowo dodają również wiele nadmiarowych
realizacji i zwalniają złożone aplikacje. Wszystkie te operacje spowalniają aplikację i wpływają na doświadczenia użytkownika końcowego.

Pytanie
------------
Dlaczego nie możemy mieć solidnego frameworka ze wszystkimi jego zaletami, ale bez wad lub z ich bardzo niewielką ilością?

To dlatego narodził się Phalcon!

W ciągu ostatnich kilku miesięcy, szeroko badaliśmy zachowanie PHP, szukaliśmy obszarów dla znaczących optymalizacji (małych i dużych).
Poprzez tego zrozumienie, udało nam się usunąć niepotrzebne walidacje, ubito kod, przeprowadzono optymalizacje i wygenerowano rozwiązania
na niskim poziomie w celu osiągnięcia maksymalnej wydajności z Phalconem.

Dlaczego?
----
* Stosowanie frameworków stało się obowiązkowe w profesjonalnym rozwoju z PHP
* Frameworki oferują filozofię zorganizowaną na łatwe utrzymanie projektów, pisanie mniej kodu i czynią pracę bardziej zabawną
* Kochamy PHP i myślimy, że może być używany do tworzenia większych i bardziej ambitnych projektów

Jak PHP funkcjonuje wewnątrz?
----------------------
* PHP ma dynamiczne i statyczne typy zmiennych. Za każdym razem gdy operacja binarna jest dokonywana (np. 2 + "2"), PHP sprawdza typy operandów w celu wykonania potencjalnej konwersji
* PHP jest interpretowany, a nie kompilowany. Główną wadą jest utrata wydajności
* Za każdym żądaniem skryptu musi on najpierw zostać zinterpretowany
* Jeśli pamięć podręczna kodu binarnego (np. APC) nie jest używana, sprawdzanie składni odbywa się za każdym razem, dla każdego pliku w żądaniu

Jak działają tradycyjne frameworki PHP?
---------------------------------------
* Wiele plików z klasami i funkcjami jest odczytywanych na każdym wywołaniem żądania. Czytanie z dysku jest kosztowne pod względem wydajności zwłaszcza, gdy plik obejmuje głębokie struktury folderów
* Nowoczesne frameworki używają leniwego załadunku (automatycznego ładowania) w celu zwiększenia wydajności (dla ładowania i wykonywania tylko potrzebnego kodu)
* Niektóre z tych klas zawierają metody, które nie są używane w każdym żądaniu, ale są ładowane zawsze zużywając pamięć
* Ciągłe ładowanie lub interpretowanie jest drogie i wpływa na wydajność
* Kod frameworka nie zmienia się bardzo często, a jednak aplikacja musi załadować i zinterpretować go za każdym razem, kiedy żądanie zostało złożone

Jak działa C-rozszerzenie PHP?
--------------------------------
* Rozszerzenia C są ładowane wraz z PHP jeden raz w momencie, kiedy demon serwera www startuje proces
* Klasy i funkcje dostarczone przez rozszerzenie są gotowe do użycia w każdej aplikacji
* Kod nie jest interpretowany, ponieważ jest już skompilowany do konkretnej platformy i procesora

Jak działa Phalcon?
----------------------
* Elementy są luźno powiązane. Z Phalconem, nic nie jest narzucone na Ciebie: możesz swobodnie korzystać z całego frameworka, czy tylko niektórych jego części, jako sklejanych składników.
* Niskopoziomowe optymalizacje zapewnia najniższe obciążenie dla aplikacji opartych o MVC
* Interakcje z bazami danych z maksymalną wydajnością przy użyciu ORM w C-języku dla PHP
* Phalcon ma bezpośredni dostęp do wewnętrznych struktur PHP optymalizując w ten sposób ich wykonanie

Dlaczego potrzebuję Phalcona?
----------------------
Każde wymagania aplikacji i zadania różnią się od siebie. Niektóre na przykład są zaprojektowane do robienia zestawu zadań i generowania treści, które rzadko się zmieniają.
Aplikacje te mogą być tworzone w dowolnym języku programowania lub frameworku. Korzystanie z pamięci podręcznej front-endu zazwyczaj sprawia, że bez względu na to, jak źle
zaprojektowane lub powolne to może być, wykonuje się bardzo szybko.

Inne aplikacje generują treści niemal natychmiast, kiedy powstały zmiany od żądania do żądania. W tym przypadku, PHP służy do adresowania wszystkich żądań i wytwarzania materiałów.
Aplikacjami tymi mogą być API, fora dyskusyjne z dużym obciążeniem ruchu, blogi z dużą liczbą komentarzy i użytkowników, aplikacje statystyczne, kokpity administratorów, systemy planowania
zasobami przedsiębiorstwa (ERP), oprogramowanie inteligentnego biznesu pracującego z danymi czasu rzeczywistego i więcej.

Aplikacja będzie tak wolna, jak jej najwolniejsze części/procesy. Phalcon oferuje bardzo szybki, bogaty framework, który pozwala programistom skupić się na tworzeniu swoich aplikacji/szybkim programowaniu.
W następstwie odpowiednich procesów kodowania, Phalcon może dostarczyć dużo więcej funkcjonalności/żądań z mniejszą konsumpcją pamięci i przetwarzaniem cykli.

Wnioski
----------
Phalcon is an effort to build the fastest framework for PHP. You now have an even easier and robust way
to develop applications with a framework implemented with the philosophy "Performance Really Matters"! Enjoy!
