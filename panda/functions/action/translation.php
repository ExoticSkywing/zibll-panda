<?php

// 翻译语言列表
function panda_translation_options() {
    $options = array(
        'zh' => 'Chinese',
        'en' => 'English',
        'fr' => 'French',
        'de' => 'German',
        'es' => 'Spanish',
        'it' => 'Italian',
    );
    return $options;
}

	
function get_language_pack_options() {
    $options = array();
        $language_pack = panda_pz('language_pack'); 
        if ( is_array( $language_pack ) && ! empty( $language_pack ) ) {
        foreach ( $language_pack as $language ) {
            if ( isset( $language['panda_language_pack'] ) && isset( $language['panda_language_name'] ) ) {
                $options[ $language['panda_language_pack'] ] = $language['panda_language_name'];
            }
        }
    }

    return $options;
}