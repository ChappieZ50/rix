<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'             => ':attribute kabul edilmelidir.',
    'active_url'           => ':attribute geçerli bir URL olmalıdır.',
    'after'                => ':attribute şundan daha eski bir tarih olmalıdır :date.',
    'after_or_equal'       => ':attribute tarihi :date tarihinden sonra veya tarihine eşit olmalıdır.',
    'alpha'                => ':attribute sadece harflerden oluşmalıdır.',
    'alpha_dash'           => ':attribute sadece harfler, rakamlar ve tirelerden oluşmalıdır.',
    'alpha_num'            => ':attribute sadece harfler ve rakamlar içermelidir.',
    'array'                => ':attribute dizi olmalıdır.',
    'before'               => ':attribute şundan daha önceki bir tarih olmalıdır :date.',
    'before_or_equal'      => ':attribute tarihi :date tarihinden önce veya tarihine eşit olmalıdır.',
    'between'              => [
        'numeric' => ':attribute :min - :max arasında olmalıdır.',
        'file'    => ':attribute :min - :max arasındaki kilobayt değeri olmalıdır.',
        'string'  => ':attribute :min - :max arasında karakterden oluşmalıdır.',
        'array'   => ':attribute :min - :max arasında nesneye sahip olmalıdır.',
    ],
    'boolean'              => ':attribute sadece doğru veya yanlış olmalıdır.',
    'confirmed'            => ':attribute tekrarı eşleşmiyor.',
    'date'                 => ':attribute geçerli bir tarih olmalıdır.',
    'date_equals'          => 'The :attribute must be a date equal to :date.',
    'date_format'          => ':attribute :format biçimi ile eşleşmiyor.',
    'different'            => ':attribute ile :other birbirinden farklı olmalıdır.',
    'digits'               => ':attribute :digits rakam olmalıdır.',
    'digits_between'       => ':attribute :min ile :max arasında rakam olmalıdır.',
    'dimensions'           => ':attribute görsel ölçüleri geçersiz.',
    'distinct'             => ':attribute alanı yinelenen bir değere sahip.',
    'email'                => ':attribute biçimi geçersiz.',
    'exists'               => 'Seçili :attribute geçersiz.',
    'file'                 => ':attribute dosya olmalıdır.',
    'filled'               => ':attribute alanının doldurulması zorunludur.',
    'gt'                   => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file'    => 'The :attribute must be greater than :value kilobytes.',
        'string'  => 'The :attribute must be greater than :value characters.',
        'array'   => 'The :attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file'    => 'The :attribute must be greater than or equal :value kilobytes.',
        'string'  => 'The :attribute must be greater than or equal :value characters.',
        'array'   => 'The :attribute must have :value items or more.',
    ],
    'image'                => ':attribute alanı resim dosyası olmalıdır.',
    'in'                   => ':attribute değeri geçersiz.',
    'in_array'             => ':attribute alanı :other içinde mevcut değil.',
    'integer'              => ':attribute tamsayı olmalıdır.',
    'ip'                   => ':attribute geçerli bir IP adresi olmalıdır.',
    'ipv4'                 => ':attribute geçerli bir IPv4 adresi olmalıdır.',
    'ipv6'                 => ':attribute geçerli bir IPv6 adresi olmalıdır.',
    'json'                 => ':attribute geçerli bir JSON değişkeni olmalıdır.',
    'lt'                   => [
        'numeric' => 'The :attribute must be less than :value.',
        'file'    => 'The :attribute must be less than :value kilobytes.',
        'string'  => 'The :attribute must be less than :value characters.',
        'array'   => 'The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file'    => 'The :attribute must be less than or equal :value kilobytes.',
        'string'  => 'The :attribute must be less than or equal :value characters.',
        'array'   => 'The :attribute must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => ':attribute değeri :max değerinden küçük olmalıdır.',
        'file'    => ':attribute değeri :max kilobayt değerinden küçük olmalıdır.',
        'string'  => ':attribute değeri :max karakter değerinden küçük olmalıdır.',
        'array'   => ':attribute değeri :max adedinden az nesneye sahip olmalıdır.',
    ],
    'mimes'                => ':attribute dosya biçimi :values olmalıdır.',
    'mimetypes'            => ':attribute dosya biçimi :values olmalıdır.',
    'min'                  => [
        'numeric' => ':attribute değeri :min değerinden büyük olmalıdır.',
        'file'    => ':attribute değeri :min kilobayt değerinden büyük olmalıdır.',
        'string'  => ':attribute değeri :min karakter değerinden büyük olmalıdır.',
        'array'   => ':attribute en az :min nesneye sahip olmalıdır.',
    ],
    'not_in'               => 'Seçili :attribute geçersiz.',
    'not_regex'            => ':attribute biçimi geçersiz.',
    'numeric'              => ':attribute sayı olmalıdır.',
    'present'              => ':attribute alanı mevcut olmalıdır.',
    'regex'                => ':attribute biçimi geçersiz.',
    'required'             => ':attribute alanı gereklidir.',
    'required_if'          => ':attribute alanı, :other :value değerine sahip olduğunda zorunludur.',
    'required_unless'      => ':attribute alanı, :other alanı :values değerlerinden birine sahip olmadığında zorunludur.',
    'required_with'        => ':attribute alanı :values varken zorunludur.',
    'required_with_all'    => ':attribute alanı herhangi bir :values değeri varken zorunludur.',
    'required_without'     => ':attribute alanı :values yokken zorunludur.',
    'required_without_all' => ':attribute alanı :values değerlerinden herhangi biri yokken zorunludur.',
    'same'                 => ':attribute ile :other eşleşmelidir.',
    'size'                 => [
        'numeric' => ':attribute :size olmalıdır.',
        'file'    => ':attribute :size kilobyte olmalıdır.',
        'string'  => ':attribute :size karakter olmalıdır.',
        'array'   => ':attribute :size nesneye sahip olmalıdır.',
    ],
    'starts_with'          => 'The :attribute must start with one of the following: :values',
    'string'               => ':attribute dizge olmalıdır.',
    'timezone'             => ':attribute geçerli bir saat dilimi olmalıdır.',
    'unique'               => ':attribute daha önceden kayıt edilmiş.',
    'uploaded'             => ':attribute yüklemesi başarısız.',
    'url'                  => ':attribute biçimi geçersiz.',
    'uuid'                 => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'title'                => 'Başlık',
        'slug'                 => 'Slug',
        'content'              => 'İçerik',
        'summary'              => 'Özet',
        'featured_image'       => 'Öne Çıkan Resim',
        'seo_title'            => 'Seo Başlık',
        'seo_description'      => 'Seo Açıklama',
        'seo_keywords'         => 'Seo Anahtar Kelimeler',
        'tags'                 => 'Etiketler',
        'categories'           => 'Kategoriler',
        'name'                 => 'İsim',
        'parent_category'      => 'Alt Kategori',
        'slider'               => 'Slider',
        'status'               => 'Durum',
        'featured'             => 'Öne Çıkan',
        'password'             => 'Şifre',
        'password_confirm'     => 'Şifre Tekrar',
        'username'             => 'Kullanıcı Adı',
        'email'                => 'E-Posta',
        'comment'              => 'Yorum',
        'message'              => 'Mesaj',
        'subject'              => 'Konu',
        'role'                 => 'Rol',
        'web'                  => 'Web Site',
        'biography'            => 'Biyografi',
        'facebook'             => 'Facebook',
        'twitter'              => 'Twitter',
        'instagram'            => 'Instagram',
        'youtube'              => 'Youtube',
        'linkedin'             => 'Linkedin',
        'pinterest'            => 'Pinterest',
        'post_per_page'        => 'Sayfa Başı Yazı Sayısı',
        'security_type'        => 'Güvenlik Türü',
        'site_logo'            => 'Site Logo',
        'site_favicon'         => 'Site Favicon',
        'phone'                => 'Telefon',
        'email_title'          => 'E-Posta Başlık',
        'email_host'           => 'E-Posta Sunucusu',
        'email_port'           => 'Port',
        'email_password'       => 'E-Posta Şifresi',
        'cache_refresh_time'   => 'Önbellek Yenilenme Zamanı',
        'status_cache_site'    => 'Web Site Önbellek',
        'g-recaptcha-response' => 'Recaptcha',
        'cookie_text'          => 'Çerez Uyarısı Metni'
    ],
];
