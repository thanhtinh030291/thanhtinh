<!DOCTYPE html>
    <html lang="ja">
        <head>
            <style>
                table img{
                    max-width: 150px;
                }
                .button {
                    background-color: #3869D4;
                    border-top: 10px solid #3869D4;
                    border-right: 18px solid #3869D4;
                    border-bottom: 10px solid #3869D4;
                    border-left: 18px solid #3869D4;
                    display: inline-block;
                    color: #FFF;
                    text-decoration: none;
                    border-radius: 3px;
                    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
                    -webkit-text-size-adjust: none;
                }
                .button--green {
                    background-color: #22BC66;
                    border-top: 10px solid #22BC66;
                    border-right: 18px solid #22BC66;
                    border-bottom: 10px solid #22BC66;
                    border-left: 18px solid #22BC66;
                }
    
                .button--red {
                    background-color: #FF6136;
                    border-top: 10px solid #FF6136;
                    border-right: 18px solid #FF6136;
                    border-bottom: 10px solid #FF6136;
                    border-left: 18px solid #FF6136;
                }
            </style>
        </head>
        <body >
            <table id="m_container" style="width:640px;color:rgb(51,51,51);margin:0 auto;border-collapse:collapse">
                <tbody>
                    <tr>
                        <td >
                            @include('templateEmail.head')
                        </td>
                    </tr>
                    <tr>
                        <td >
                            @yield('content')
                        </td>
                    </tr>
                    <tr>
                        <td >
                            @include('templateEmail.footter')
                        </td>
                    </tr>
                </tbody>
            </table>
        </body>
    </html>