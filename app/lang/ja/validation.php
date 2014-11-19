<?php

return array(
    "accepted"         => ":attributeが確認されていません。",
    "active_url"       => ":attributeは無効なURLです。",
    "after"            => ":attributeは:dateより後の日付でなければなりません。",
    "alpha"            => ":attributeにはアルファベット以外使用できません。",
    "alpha_dash"       => ":attributeにはアルファベット、数字、ハイフン、アンダーバー以外使用できません。",
    "alpha_num"        => ":attributeにはアルファベット、数字以外使用できません。",
    "before"           => ":attributeは:dateより前の日付でなければなりません。",
    "between"          => array(
        "numeric" => ":attributeは:min～:maxの範囲である必要があります。",
        "file"    => ":attributeのファイルサイズは:min～:maxキロバイトの範囲である必要があります。",
        "string"  => ":attributeの長さは:min～:max文字の範囲である必要があります。",
    ),
    "confirmed"        => ":attributeは確認欄と一致しませんでした。",
    "date"             => ":attributeは正しい日付ではありません。",
    "date_format"      => ":attributeは:format形式ではありません。",
    "different"        => ":attributeと:otherは異なる必要があります。",
    "digits"           => ":attributeは:digits桁である必要があります。",
    "digits_between"   => ":attributeは:min～:max桁の範囲である必要があります。",
    "email"            => ":attributeは正しいメールアドレスではありません。",
    "exists"           => "選択された:attributeは存在しませんでした。",
    "image"            => ":attributeは画像ファイルである必要があります。",
    "in"               => "選択された:attributeは正しくありません。",
    "integer"          => ":attributeは整数である必要があります。",
    "ip"               => ":attributeは正しいIPアドレスではありません。",
    "max"              => array(
        "numeric" => ":attributeは:max以下である必要があります。",
        "file"    => ":attributeのファイルサイズは:maxキロバイト以下である必要があります。",
        "string"  => ":attributeの長さは:max文字以下である必要があります。",
    ),
    "mimes"            => ":attributeのファイル種別は:valuesである必要があります。",
    "min"              => array(
        "numeric" => ":attributeは:min以上である必要があります。",
        "file"    => ":attributeのファイルサイズは:minキロバイト以上である必要があります。",
        "string"  => ":attributeの長さは :min文字以上である必要があります。",
    ),
    "not_in"           => "選択された:attributeは正しくありません。",
    "numeric"          => ":attributeは数値である必要があります。",
    "regex"            => ":attributeの形式は正しくありません。",
    "required"         => ":attributeは必須です。",
    "required_if"      => ":otherが:valueである場合、:attributeは必須です。",
    "required_with"    => ":valuesが指定されている場合、:attributeは必須です。",
    "required_without" => ":valuesが指定されていない場合、:attributeは必須です。",
    "same"             => ":attributeと:otherが一致しません。",
    "size"             => array(
        "numeric" => ":attributeは:sizeである必要があります。",
        "file"    => ":attributeのファイルサイズは:sizeキロバイトである必要があります。",
        "string"  => ":attributeの長さは:size文字である必要があります。",
    ),
    "unique"           => ":attributeはすでに使われています。",
    "url"              => ":attributeは正しいURL形式ではありません。",
    "mb_between" => ":attributeは:min文字以上:max文字以内である必要があります。",
    "mb_max" => ":attributeは:max文字以内である必要があります。",
    "mb_min" => ":attributeは:min文字以上である必要があります。",

    'custom' => array(
        'attribute-name' => array(
                'rule-name' => 'custom-message',
        ),
    ),

    'attributes' => array(),
    
);
