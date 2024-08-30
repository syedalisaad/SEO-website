var Notify = function ()
{
    let self = $(this);

    let notifyTotal = $('.const-notify-count');
    let notifyRender = $('.const-notify-view');

    this.templateNotify = function (received) {
        return '\
        <div class="dropdown-divider"></div>\
        <a href="' + received.location + '" class="dropdown-item cust-notify-unread">\
            <i class="fas fa-envelope mr-2"></i> <span>' + received.message + '</span>\
            <span class="float-right text-muted text-sm">' + received.humans_time + '</span>\
        </a>\
        ';
    },

    this.notifyOurSystem = function (data) {

        if (data) {

            let notifyCount = (parseInt(notifyTotal.html()) + 1);

            notifyTotal.html(notifyCount);
            notifyRender.prepend(this.templateNotify({
                location: data.destination,
                message: data.message,
                humans_time: data.created_at
            }));

            $(document).Toasts('create', {
                title: 'New Message!',
                subtitle: data.created_at,
                body: data.message,
                autohide: true,
                delay: 3000,
                class: 'bg-info'
            })
        }
    },

    //Pusher Configurations
    this.notifyPusherConfigure = function( user_id )
    {
        let pusher = new Pusher( $('meta[name=pusher-app-key]').attr('content') , {
            cluster: $('meta[name=pusher-app-cluster]').attr('content') //'mt1'
        });

        //Subscribe to the channel we specified in our Laravel Event
        let channel = pusher.subscribe('brodcast-message-' + user_id);

        channel.bind('notify-brodcast-received', function(data){
            new Notify().notifyOurSystem(data.notify_data || null)
        });
    }
}
