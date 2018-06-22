<form action="{{route('room.index', ['id'=>$id])}}" method="get">
    <input name="access_password" value="" type="text" placeholder="访问密码">
    <input type="submit" value="提交">
</form>