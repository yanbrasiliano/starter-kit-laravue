import { Notify } from 'quasar';

export default function notify(message, color = 'positive', timeout = 5000) {
  Notify.create({
    position: 'top-right',
    color,
    message: message,
    timeout,
  });
}
