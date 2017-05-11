<!DOCTYPE html>
<html>
    <head>
        <title>Fennec Administration</title>
    </head>
    <body style="margin: auto; text-align: center;">
        <form method="POST">
            <div style="color: #F00;"><?=(isset($error)) ? $error : ""?></div>
            <div><label style="font-weight: bold;">Username:</label></div>
            <div><input type="text" name="username" style="width: 150px;" /></div>
            <div><label style="font-weight: bold;">Password:</label></div>
            <div><input type="password" name="password" style="width: 150px;" /></div>
            <div><button type="submit">Login</button></div>
        </form>
    </body>
</html>