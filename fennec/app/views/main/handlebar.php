<!DOCTYPE html>
<html>
    <head>
        <title>{{title}}</title>
    </head>
    <body>
        <h1>{{title}}</h1>
        <select>
            {{#each options}}
            <option>{{this}}</option>
            {{/each}}
        </select>
    </body>
</html>