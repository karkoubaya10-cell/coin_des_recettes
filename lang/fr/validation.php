<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Lignes de langage de validation
    |--------------------------------------------------------------------------
    |
    | Les lignes suivantes contiennent les messages d’erreur par défaut utilisés
    | par la classe validator. Certaines règles possèdent plusieurs versions,
    | comme les règles de taille. N’hésitez pas à modifier ces messages ici.
    |
    */

    'accepted' => 'Le champ :attribute doit être accepté.',
    'accepted_if' => 'Le champ :attribute doit être accepté lorsque :other est :value.',
    'active_url' => 'Le champ :attribute doit être une URL valide.',
    'after' => 'Le champ :attribute doit être une date après :date.',
    'after_or_equal' => 'Le champ :attribute doit être une date après ou égale à :date.',
    'alpha' => 'Le champ :attribute ne doit contenir que des lettres.',
    'alpha_dash' => 'Le champ :attribute ne doit contenir que des lettres, chiffres, tirets et underscores.',
    'alpha_num' => 'Le champ :attribute ne doit contenir que des lettres et chiffres.',
    'any_of' => 'Le champ :attribute est invalide.',
    'array' => 'Le champ :attribute doit être un tableau.',
    'ascii' => 'Le champ :attribute ne doit contenir que des caractères alphanumériques ASCII simples.',
    'before' => 'Le champ :attribute doit être une date avant :date.',
    'before_or_equal' => 'Le champ :attribute doit être une date avant ou égale à :date.',
    'between' => [
        'array' => 'Le champ :attribute doit contenir entre :min et :max éléments.',
        'file' => 'Le champ :attribute doit être entre :min et :max kilo-octets.',
        'numeric' => 'Le champ :attribute doit être entre :min et :max.',
        'string' => 'Le champ :attribute doit contenir entre :min et :max caractères.',
    ],
    'boolean' => 'Le champ :attribute doit être vrai ou faux.',
    'can' => 'Le champ :attribute contient une valeur non autorisée.',
    'confirmed' => 'La confirmation du champ :attribute ne correspond pas.',
    'contains' => 'Le champ :attribute manque une valeur obligatoire.',
    'current_password' => 'Le mot de passe est incorrect.',
    'date' => 'Le champ :attribute doit être une date valide.',
    'date_equals' => 'Le champ :attribute doit être une date égale à :date.',
    'date_format' => 'Le champ :attribute doit correspondre au format :format.',
    'decimal' => 'Le champ :attribute doit avoir :decimal décimales.',
    'declined' => 'Le champ :attribute doit être refusé.',
    'declined_if' => 'Le champ :attribute doit être refusé lorsque :other est :value.',
    'different' => 'Les champs :attribute et :other doivent être différents.',
    'digits' => 'Le champ :attribute doit contenir :digits chiffres.',
    'digits_between' => 'Le champ :attribute doit contenir entre :min et :max chiffres.',
    'dimensions' => 'Les dimensions de l’image du champ :attribute sont invalides.',
    'distinct' => 'Le champ :attribute a une valeur dupliquée.',
    'doesnt_contain' => 'Le champ :attribute ne doit contenir aucun des éléments suivants : :values.',
    'doesnt_end_with' => 'Le champ :attribute ne doit pas se terminer par :values.',
    'doesnt_start_with' => 'Le champ :attribute ne doit pas commencer par :values.',
    'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
    'ends_with' => 'Le champ :attribute doit se terminer par l’un des éléments suivants : :values.',
    'enum' => 'La valeur sélectionnée pour :attribute est invalide.',
    'exists' => 'La valeur sélectionnée pour :attribute est invalide.',
    'extensions' => 'Le champ :attribute doit avoir l’une des extensions suivantes : :values.',
    'file' => 'Le champ :attribute doit être un fichier.',
    'filled' => 'Le champ :attribute doit contenir une valeur.',
    'gt' => [
        'array' => 'Le champ :attribute doit contenir plus de :value éléments.',
        'file' => 'Le champ :attribute doit être supérieur à :value kilo-octets.',
        'numeric' => 'Le champ :attribute doit être supérieur à :value.',
        'string' => 'Le champ :attribute doit contenir plus de :value caractères.',
    ],
    'gte' => [
        'array' => 'Le champ :attribute doit contenir au moins :value éléments.',
        'file' => 'Le champ :attribute doit être supérieur ou égal à :value kilo-octets.',
        'numeric' => 'Le champ :attribute doit être supérieur ou égal à :value.',
        'string' => 'Le champ :attribute doit contenir au moins :value caractères.',
    ],
    'hex_color' => 'Le champ :attribute doit être une couleur hexadécimale valide.',
    'image' => 'Le champ :attribute doit être une image.',
    'in' => 'La valeur sélectionnée pour :attribute est invalide.',
    'in_array' => 'Le champ :attribute doit exister dans :other.',
    'in_array_keys' => 'Le champ :attribute doit contenir au moins une des clés suivantes : :values.',
    'integer' => 'Le champ :attribute doit être un entier.',
    'ip' => 'Le champ :attribute doit être une adresse IP valide.',
    'ipv4' => 'Le champ :attribute doit être une adresse IPv4 valide.',
    'ipv6' => 'Le champ :attribute doit être une adresse IPv6 valide.',
    'json' => 'Le champ :attribute doit être une chaîne JSON valide.',
    'list' => 'Le champ :attribute doit être une liste.',
    'lowercase' => 'Le champ :attribute doit être en minuscules.',
    'lt' => [
        'array' => 'Le champ :attribute doit contenir moins de :value éléments.',
        'file' => 'Le champ :attribute doit être inférieur à :value kilo-octets.',
        'numeric' => 'Le champ :attribute doit être inférieur à :value.',
        'string' => 'Le champ :attribute doit contenir moins de :value caractères.',
    ],
    'lte' => [
        'array' => 'Le champ :attribute ne doit pas contenir plus de :value éléments.',
        'file' => 'Le champ :attribute doit être inférieur ou égal à :value kilo-octets.',
        'numeric' => 'Le champ :attribute doit être inférieur ou égal à :value.',
        'string' => 'Le champ :attribute doit contenir au maximum :value caractères.',
    ],
    'mac_address' => 'Le champ :attribute doit être une adresse MAC valide.',
    'max' => [
        'array' => 'Le champ :attribute ne doit pas contenir plus de :max éléments.',
        'file' => 'Le champ :attribute ne doit pas dépasser :max kilo-octets.',
        'numeric' => 'Le champ :attribute ne doit pas dépasser :max.',
        'string' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
    ],
    'max_digits' => 'Le champ :attribute ne doit pas contenir plus de :max chiffres.',
    'mimes' => 'Le champ :attribute doit être un fichier de type : :values.',
    'mimetypes' => 'Le champ :attribute doit être un fichier de type : :values.',
    'min' => [
        'array' => 'Le champ :attribute doit contenir au moins :min éléments.',
        'file' => 'Le champ :attribute doit faire au moins :min kilo-octets.',
        'numeric' => 'Le champ :attribute doit être au moins :min.',
        'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
    ],
    'min_digits' => 'Le champ :attribute doit contenir au moins :min chiffres.',
    'missing' => 'Le champ :attribute doit être manquant.',
    'missing_if' => 'Le champ :attribute doit être manquant lorsque :other est :value.',
    'missing_unless' => 'Le champ :attribute doit être manquant sauf si :other est :value.',
    'missing_with' => 'Le champ :attribute doit être manquant lorsque :values est présent.',
    'missing_with_all' => 'Le champ :attribute doit être manquant lorsque :values sont présents.',
    'multiple_of' => 'Le champ :attribute doit être un multiple de :value.',
    'not_in' => 'La valeur sélectionnée pour :attribute est invalide.',
    'not_regex' => 'Le format du champ :attribute est invalide.',
    'numeric' => 'Le champ :attribute doit être un nombre.',
    'password' => [
        'letters' => 'Le champ :attribute doit contenir au moins une lettre.',
        'mixed' => 'Le champ :attribute doit contenir au moins une majuscule et une minuscule.',
        'numbers' => 'Le champ :attribute doit contenir au moins un chiffre.',
        'symbols' => 'Le champ :attribute doit contenir au moins un symbole.',
        'uncompromised' => 'Le :attribute fourni apparaît dans une fuite de données. Veuillez choisir un autre :attribute.',
    ],
    'present' => 'Le champ :attribute doit être présent.',
    'present_if' => 'Le champ :attribute doit être présent lorsque :other est :value.',
    'present_unless' => 'Le champ :attribute doit être présent sauf si :other est :value.',
    'present_with' => 'Le champ :attribute doit être présent lorsque :values est présent.',
    'present_with_all' => 'Le champ :attribute doit être présent lorsque :values sont présents.',
    'prohibited' => 'Le champ :attribute est interdit.',
    'prohibited_if' => 'Le champ :attribute est interdit lorsque :other est :value.',
    'prohibited_if_accepted' => 'Le champ :attribute est interdit lorsque :other est accepté.',
    'prohibited_if_declined' => 'Le champ :attribute est interdit lorsque :other est refusé.',
    'prohibited_unless' => 'Le champ :attribute est interdit sauf si :other est dans :values.',
    'prohibits' => 'Le champ :attribute interdit la présence de :other.',
    'regex' => 'Le format du champ :attribute est invalide.',
    'required' => 'Le champ :attribute est obligatoire.',
    'required_array_keys' => 'Le champ :attribute doit contenir des entrées pour :values.',
    'required_if' => 'Le champ :attribute est obligatoire lorsque :other est :value.',
    'required_if_accepted' => 'Le champ :attribute est obligatoire lorsque :other est accepté.',
    'required_if_declined' => 'Le champ :attribute est obligatoire lorsque :other est refusé.',
    'required_unless' => 'Le champ :attribute est obligatoire sauf si :other est dans :values.',
    'required_with' => 'Le champ :attribute est obligatoire lorsque :values est présent.',
    'required_with_all' => 'Le champ :attribute est obligatoire lorsque :values sont présents.',
    'required_without' => 'Le champ :attribute est obligatoire lorsque :values n’est pas présent.',
    'required_without_all' => 'Le champ :attribute est obligatoire lorsque aucun de :values n’est présent.',
    'same' => 'Le champ :attribute doit être identique à :other.',
    'size' => [
        'array' => 'Le champ :attribute doit contenir :size éléments.',
        'file' => 'Le champ :attribute doit faire :size kilo-octets.',
        'numeric' => 'Le champ :attribute doit être :size.',
        'string' => 'Le champ :attribute doit contenir :size caractères.',
    ],
    'starts_with' => 'Le champ :attribute doit commencer par :values.',
    'string' => 'Le champ :attribute doit être une chaîne de caractères.',
    'timezone' => 'Le champ :attribute doit être un fuseau horaire valide.',
    'unique' => 'Le champ :attribute est déjà utilisé.',
    'uploaded' => 'Le téléversement du champ :attribute a échoué.',
    'uppercase' => 'Le champ :attribute doit être en majuscules.',
    'url' => 'Le champ :attribute doit être une URL valide.',
    'ulid' => 'Le champ :attribute doit être un ULID valide.',
    'uuid' => 'Le champ :attribute doit être un UUID valide.',

    /*
    |--------------------------------------------------------------------------
    | Lignes personnalisées
    |--------------------------------------------------------------------------
    |
    | Vous pouvez spécifier ici vos propres messages personnalisés en utilisant
    | la convention "attribute.rule". Cela permet de créer rapidement des messages
    | spécifiques à une règle donnée.
    |
    */

    'custom' => [
        'auteur' => [
            'required' => 'Le nom de l auteur est obligatoire.',
            'min' => 'Le nom de l auteur doit contenir au moins :min caracteres.',
            'max' => 'Le nom de l auteur ne doit pas depasser :max caracteres.',
            'regex' => 'Le nom de l auteur doit contenir uniquement des lettres.',
        ],
        'titre' => [
            'required' => 'Le titre de la recette est obligatoire.',
            'min' => 'Le titre doit contenir au moins :min caracteres.',
            'max' => 'Le titre ne doit pas depasser :max caracteres.',
            'regex' => 'Le titre ne peut pas etre vide ou contenir seulement des espaces.',
        ],
        'description' => [
            'required' => 'La description est obligatoire.',
            'min' => 'La description doit contenir au moins :min caracteres.',
            'max' => 'La description ne doit pas depasser :max caracteres.',
            'regex' => 'La description ne peut pas etre vide ou contenir seulement des espaces.',
        ],
        'ingredients' => [
            'required' => 'Les ingredients sont obligatoires.',
            'min' => 'Les ingredients doivent contenir au moins :min caracteres.',
            'max' => 'Les ingredients ne doivent pas depasser :max caracteres.',
            'regex' => 'Les ingredients ne peuvent pas etre vides ou contenir seulement des espaces.',
        ],
        'temps_preparation' => [
            'required' => 'Le temps de preparation est obligatoire.',
            'integer' => 'Le temps de preparation doit etre un nombre entier.',
            'min' => 'Le temps de preparation doit etre d au moins :min minute.',
            'max' => 'Le temps de preparation ne doit pas depasser :max minutes.',
        ],
        'categorie_id' => [
            'required' => 'La categorie est obligatoire.',
            'exists' => 'La categorie selectionnee est invalide.',
        ],
        'image' => [
            'image' => 'Le fichier choisi doit etre une image valide.',
            'mimes' => 'L image doit etre au format :values.',
            'max' => 'La taille de l image ne doit pas depasser 2 Mo.',
        ],
        'etapes' => [
            'required' => 'Ajoute au moins une etape.',
            'array' => 'Les etapes envoyees sont invalides.',
            'min' => 'Ajoute au moins une etape.',
        ],
        'etapes.*' => [
            'required' => 'Chaque etape est obligatoire.',
            'min' => 'Chaque etape doit contenir au moins :min caracteres.',
            'max' => 'Chaque etape ne doit pas depasser :max caracteres.',
            'regex' => 'Chaque etape ne peut pas etre vide ou contenir seulement des espaces.',
        ],
        'name' => [
            'required' => 'Le nom est obligatoire.',
            'max' => 'Le nom ne doit pas depasser :max caracteres.',
        ],
        'email' => [
            'required' => 'L adresse email est obligatoire.',
            'email' => 'L adresse email doit etre valide.',
            'unique' => 'Cette adresse email est deja utilisee.',
        ],
        'password' => [
            'required' => 'Le mot de passe est obligatoire.',
            'confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ],
        'token' => [
            'required' => 'Le token de reinitialisation est obligatoire.',
        ],
        'contenu' => [
            'required' => 'Le commentaire est obligatoire.',
            'min' => 'Le commentaire doit contenir au moins :min caracteres.',
        ],
        'xml_file' => [
            'required' => 'Veuillez selectionner un fichier XML.',
            'file' => 'Le fichier envoye est invalide.',
            'mimes' => 'Le fichier doit etre de type XML.',
            'max' => 'Le fichier XML est trop volumineux.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Attributs personnalisés
    |--------------------------------------------------------------------------
    |
    | Ces lignes vous permettent de remplacer l’attribut par un texte plus lisible,
    | comme "Adresse e-mail" au lieu de "email". Cela rend les messages plus clairs.
    |
    */

    'attributes' => [
        'name' => 'nom',
        'email' => 'adresse email',
        'password' => 'mot de passe',
        'password_confirmation' => 'confirmation du mot de passe',
        'token' => 'token',
        'contenu' => 'commentaire',
        'xml_file' => 'fichier XML',
        'titre' => 'titre',
        'description' => 'description',
        'ingredients' => 'ingredients',
        'temps_preparation' => 'temps de preparation',
        'image' => 'image',
        'categorie_id' => 'categorie',
    ],

];
