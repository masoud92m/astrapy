import axios from 'axios';
import Swal from 'sweetalert2';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Swal = Swal;
const url = window.location;
window.basePath = url.protocol + '//' + url.host + url.pathname;
