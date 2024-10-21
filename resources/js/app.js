require('./bootstrap');
// 4-4font-awesomeを読み込む処理を実装しよう
import { library, dom } from '@fortawesome/fontawesome-svg-core'
import { faAddressCard, faClock } from '@fortawesome/free-regular-svg-icons'
import { faSearch, faStoreAlt, faShoppingBag, faSignOutAlt, faYenSign, faCamera } from '@fortawesome/free-solid-svg-icons'

library.add(faSearch, faAddressCard, faStoreAlt, faShoppingBag, faSignOutAlt, faYenSign, faClock, faCamera);

dom.watch();


document.querySelector('.image-picker input')
    .addEventListener('change', (e) => {
        const input = e.target;
        const reader = new FileReader();
        reader.onload = (e) => {
            input.closest('.image-picker').querySelector('img').src = e.target.result
        };
        reader.readAsDataURL(input.files[0]);
    });
// JavaScriptでファイル選択時にその内容を読み込み、画像を即座にプレビューする機能を実装

// このコードは、Font Awesome のアイコンの読み込みと、ファイル選択時の画像プレビュー機能を実装しており、ユーザーが操作した際に直感的なUI体験を提供します