<!-- ملف resources/views/form.blade.php -->
<form action="/submit" method="post">
    @csrf <!-- تضمين حماية CSRF -->
    <label for="first_name">الاسم الأول:</label>
    <input type="text" id="first_name" name="first_name"><br>

    <label for="last_name">اسم العائلة:</label>
    <input type="text" id="last_name" name="last_name"><br>

    <label for="mother_name">اسم الأم:</label>
    <input type="text" id="mother_name" name="mother_name"><br>

    <label for="birthday">تاريخ الميلاد:</label>
    <input type="date" id="birthday" name="birthday"><br>

    <label for="address">العنوان:</label>
    <textarea id="address" name="address"></textarea><br>

    <label for="national_number">الرقم الوطني:</label>
    <input type="number" id="national_number" name="national_number"><br>

    <button type="submit">إرسال</button>
</form>
