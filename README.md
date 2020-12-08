# Local Ortamda Kurulum
* docker-compose up -d
* docker-compose exec app php artisan migrate
* docker-compose exec app php artisan db:seed
* docker-compose exec app php artisan queue:work


# Kullanım
* Admin
    * Giriş Bilgileri
    ````
      Email : admin@admin.com 
      Şifre : 1234   
    ````
    * Giriş yapıldıktan sonra Anasayfadan aşağıdaki sayfalara ulaşılabilir
        * Çalışanlar
            * Çalışan Listeleme
            * Çalışan Ekleme
            * Güncelleme
        * İşler
            * İş Listesi
            * İş Ekleme
            * İş Güncelleme
* Api
    * Giriş Yapma ( Admin'den oluşturulan bilgilerle giriş yapılabilir)
      ```
      curl --location --request POST 'http://localhost:8884/api/employee/login' \
        --header 'Content-Type: application/json' \
        --data-raw '{
        "email" : "calisan1@email.com",
        "password" : "1234"
        }'```   
    * İş Listesi
        ```
           curl --location --request GET 'http://localhost:8884/api/employee/job-list' \
            --header 'Authorization: Bearer {TOKEN}'
        ```
    * İş Statü Güncelleme
      ```
       curl --location --request POST 'http://localhost:8884/api/employee/job-update-status/{JOB_ID}' \
        --header 'Authorization: Bearer {token}' \
        --header 'Content-Type: application/json' \
        --data-raw '{
            "status" : {1 , 2 ,3 ,4 değerlerinden biri gönderilmelidir}
        }'
      ```
    * Yeni İş Oluşturma ( Çalışanın üzerindeki işlerden bağımsız işe gidebilme durumu )
      ```
        curl --location --request POST 'http://localhost:8884/api/employee/job-create' \
        --header 'Authorization: Bearer {TOKEN}}' \
        --header 'Content-Type: application/json' \
        --data-raw '{
        "name" : "Test işi",
        "description" : "Açıklaması",
        "city_id" : 1,
        "county_id" : 2,
        "address" : "test Adresi",
        "date" : "2020/12/08",
        "period" : {1 , 2 ,3 ,4 değerlerinden biri gönderilmelidir}
        }'
      ```
**NOT: Login hariç tüm Api endpoint'lerinde header'da token bilgisinin bulunması zorunludur, bu bilgi login işleminin response'ında bulunmaktadır.**

**Admin Panelden "İş Oluşturma" , "İş Güncelleme" , "Api'den İş Oluşturma" işlemlerinden sonra kullanıcının tamamlanmamış olan tüm işlerinin öncelikleri Google Direction Api yardımıyla period ve tarih baz alınarak en doğru güzargah'a göre güncellenmektedir."**
* Örnek; 
  * **08.12.2020**
    * 09:00:00 - 12:00:00
        * İş 1 
        * İş 2
        * İş 3
    * 12:00:00 - 18:30:00
        * İş 4
        * İş 5
    * 18:30:00 - 21:00:00
        * İş 6
  * **09.12.2020**
    * 09:00:00 - 12:00:00
        * İş 1 
        * İş 2
        * İş 3
    * 12:00:00 - 18:30:00
        * İş 4
        * İş 5
    * 18:30:00 - 21:00:00
        * İş 6
  
