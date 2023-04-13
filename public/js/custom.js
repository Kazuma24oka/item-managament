// 画像登録編集
function previewImage() {
    const fileInput = document.getElementById('file');
    const file = fileInput.files[0];
    const preview = document.getElementById('preview-img');
    const reader = new FileReader();
    const isEditMode = fileInput.dataset.edit === "true";

    reader.addEventListener('load', function () {
        preview.src = reader.result;
        preview.style.display = 'block'; // 画像のプレビューを表示する
    }, false);

    if (file) {
        document.querySelector('.file-label').textContent = file.name;
        reader.readAsDataURL(file);
    } else if (isEditMode) {
        // ファイルが選択されておらず、編集ページである場合プレビューのsrcを元画像に設定
        preview.src = "{{ asset($item->image) }}";
        // ラベルテキストを元のファイル名に戻す
        document.querySelector('.file-label').textContent = "{{ $item->name }}";
    } else {
        // ファイルが選択されておらず、編集ページでもない場合はラベルテキストをリセット
        document.querySelector('.file-label').textContent = '画像を選択';
        preview.style.display = 'none'; // 画像のプレビューを非表示にする
    }
}

// 一度しか登録フォームを押せない
document.querySelector('form').addEventListener('submit', function() {
    document.getElementById('submit-button').disabled = true;
});