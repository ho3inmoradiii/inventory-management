class Notification {
    success(){
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: 'با موفقیت انجام شد.',
            timeOut: 1000,
        }).show();
    }

    alert(){
        new Noty({
            type: 'alert',
            layout: 'topRight',
            text: 'مطمئنی؟',
            timeOut: 1000,
        }).show();
    }

    error(){
        new Noty({
            type: 'alert',
            layout: 'topRight',
            text: 'مشکلی رخ داده است',
            timeOut: 1000,
        }).show();
    }

    warning(){
        new Noty({
            type: 'warning',
            layout: 'topRight',
            text: 'ooooops ....',
            timeOut: 1000,
        }).show();
    }
}
