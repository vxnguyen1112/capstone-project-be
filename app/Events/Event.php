<?php

    namespace App\Events;

    use Illuminate\Broadcasting\Channel;
    use Illuminate\Broadcasting\InteractsWithSockets;
    use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
    use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
    use Illuminate\Foundation\Events\Dispatchable;
    use Illuminate\Queue\SerializesModels;

    class Event implements ShouldBroadcastNow
    {
        use Dispatchable, InteractsWithSockets, SerializesModels;

        public $message;

        public $id_send;
        public $id_receive;

        public function __construct($id_receive)
        {
            $this->id_receive = $id_receive;
        }

        /**
         * Create a new event instance.
         */
        public function create($action, $id, $data)
        {
            $this->message = [
                'event' => "{$action}",
                'data' => $data
            ];
            $this->id_send = $id;
            return $this;
        }

        /**
         * Get the channels the event should broadcast on.
         *
         * @return \Illuminate\Broadcasting\Channel|array
         */
        public function broadcastOn(): Channel
        {
            return new Channel("channel-{$this->id_receive}");
        }

        public function broadcastAs()
        {
            return "{$this->message["event"]}";
        }
    }
