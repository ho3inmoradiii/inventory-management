class Notification {
    success(){
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: 'با موفقیت انجام شد',
            progressBar:true,
            timeout:3000
        }).show();
    }

    alert(){
        new Noty({
            type: 'alert',
            layout: 'topRight',
            text: 'مطمئنی؟',
            progressBar:true,
            timeout:3000
        }).show();
    }

    error(){
        new Noty({
            type: 'alert',
            layout: 'topRight',
            text: 'مشکلی رخ داده است',
            progressBar:true,
            timeout:3000
        }).show();
    }

    warning(){
        new Noty({
            type: 'warning',
            layout: 'topRight',
            text: 'ooooops ....',
            progressBar:true,
            timeout:3000
        }).show();
    }

    image_validation(){
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: 'حجم فایل بیشتر از 1 مگابایت است',
            progressBar:true,
            timeout:3000
        }).show();
    }
}

export default Notification = new Notification;
