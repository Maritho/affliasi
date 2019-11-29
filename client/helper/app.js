export const downloadCsv = (data, filename) => {
    // const blob = new File([data], filename, { type: "text/csv" }),
    // url = window.URL.createObjectURL(blob);

    const link = document.createElement('a');

    link.href = data;

    link.setAttribute('download', filename);

    document.body.appendChild(link);

    link.click();
};

export const capitalLetter = (str) => {

    if (str !== undefined && str !== null) {
        return str.replace(/\w\S*/g, function(txt){
            if (txt === 'DKI' || txt === 'DI') {
                return txt;
            } else {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            }
        });
    } else {
        return '';
    }
};

export const fileNameFromUrl = (str) => {

    if (typeof str === 'string' || str instanceof String) {
        let fileArr = str.split('/');

        return fileArr[(fileArr.length - 1)];

    } else {
        return '';
    }
};

export const isNull = (str) => {

    if (str !== undefined && str !== null) {
        return false;
    } else {
        return true;
    }
};

export const listDay = () => {
    let day = [];

    for (let i = 1; i <= 31; i++) {
        if (i < 10) i = '0' + i;

        day.push(i);
    }

    return day;
};

export const listMonth = () => {
    let monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    let month = [];

    for (let i = 0; i < monthNames.length; i++) {
        let label = monthNames[i];

        if (i < 10) i = '0' + i;

        month.push({value: (i), label: label});
    }

    return month;
};

export const listYear = () => {
    let year = [];
    let d = new Date();

    for (let i = d.getFullYear(); i < (d.getFullYear() + 1); i++) {
        year.push(i);
    }

    return year;
};

export const listHour = () => {
    let hour = [];

    for (let i = 0; i <= 24; i++) {
        if (i < 10) i = '0' + i;

        hour.push(i);
    }

    return hour;
};

export const listMinute = () => {
    let minute = [];

    for (let i = 0; i <= 60; i++) {
        if (i < 10) i = '0' + i;

        minute.push(i);
    }

    return minute;
};

export const priceDecimal = (string) => {
    if (string !== null && string !== undefined) {
        string = string.toString().replace('.00', '');
        
        string += '';
        let x = string.split('.');
        let x1 = x[0];
        let x2 = x.length > 1 ? '.' + x[1] : '';
        let rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    } else {
        return '-';
    }
};

export const encodeQueryData = (data) => {
    let ret = [];

    for (let d in data) ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
  
    return ret.join('&');
};

export const extractHostname = (url) => {
    let hostname;

    if (url !== null && url !== undefined) {
        if (url.indexOf("://") > -1) {
            hostname = url.split('/')[2];
        }
        else {
            hostname = url.split('/')[0];
        }

        hostname = hostname.split(':')[0];

        hostname = hostname.split('?')[0];

        return hostname;
    } else {
        return '';
    }
};

export const dateNumber = (date) => {
    if (date !== undefined && date !== null && date !== '') {

        let a = date.split(/[^0-9]/);
        let d = new Date (a[0],a[1]-1,a[2],a[3],a[4],a[5] );

        let i = d.getDate();
        let m = (Number(d.getMonth()) + Number(1));
        let y = d.getFullYear();
        let h = d.getHours();
        let x = d.getMinutes();

        if (i < 10) {
            i = '0' + i;
        }

        if (m < 10) {
            m = '0' + m;
        }

        if (h < 10) {
            h = '0' + h;
        }

        if (x < 10) {
            x = '0' + x;
        }

        return  i + '/' + m + '/' + y + ' ' + h + ':' + x;
    } else {
        return '';
    }
};

export const dateMonth = (date, type = '') => {
    if (date !== undefined && date !== null && date !== '') {

        let monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des"];

        let a = date.split(/[^0-9]/);
        let d = new Date (a[0],a[1]-1,a[2],a[3],a[4],a[5] );

        let i = d.getDate();
        let m = d.getMonth();
        let y = d.getFullYear();

        let time = '';

        if (type === 'full') {
            let h = d.getHours();
            let x = d.getMinutes();

            if (h < 10) {
                h = '0' + h;
            }

            if (x < 10) {
                x = '0' + x;
            }

            time = ' ' + h + ':' + x;
        }

        return  i + ' ' + monthNames[m] + ' ' + y + time;
    } else {
        return '';
    }
};

export const dateDayNumber = (date) => {
    if (date !== undefined && date !== null && date !== '') {

        let a = date.split(/[^0-9]/);
        let d = new Date (a[0],a[1]-1,a[2],a[3],a[4],a[5] );

        let i = d.getDate();
        let m = (Number(d.getMonth()) + Number(1));
        let y = d.getFullYear();
        let n = d.getDay();

        let day = [];

        day.push('Minggu');
        day.push('Senin');
        day.push('Selasa');
        day.push('Rabu');
        day.push('Kamis');
        day.push('Jumat');
        day.push('Sabtu');

        if (i < 10) {
            i = '0' + i;
        }

        if (m < 10) {
            m = '0' + m;
        }

        return  day[n] + ', ' + i + '/' + m + '/' + y;
    } else {
        return '';
    }
};

export const dateHourNumber = (date) => {
    if (date !== undefined && date !== null && date !== '') {

        let a = date.split(/[^0-9]/);
        let d = new Date (a[0],a[1]-1,a[2],a[3],a[4],a[5] );

        let h = d.getHours();
        let x = d.getMinutes();

        if (h < 10) {
            h = '0' + h;
        }

        if (x < 10) {
            x = '0' + x;
        }

        return h + ':' + x;
    } else {
        return '';
    }
};

export const getLastMonths = () => {

  let monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
  ];

  let today = new Date();
  let lastsMonths = [];

  for (let i = 0; i < 12; i++) {
    let month = today.getMonth() - i;
    let year = today.getFullYear();

    if (month < 0) {
        month = 12 + month;

        year = year - 1;
    }

    lastsMonths.push({label: monthNames[month] + ' ' + year, year: year, value: (Number(month) + Number(1))});
  }

  return lastsMonths;
};

export const textTruncate = (Str, Length, Ending) => {
    if (Length === null) {
        Length = 100;
    }

    if (Ending === null) {
        Ending = '...';
    }

    if (Str !== undefined) {
        if (Str.length > Length) {
            return Str.substring(0, Length - Ending.length) + Ending;
        } else {
            return Str;
        }
    } else {
        return Str;
    }
};

export const openMessageAlert = (message) => {
    let processNotif = document.querySelector('.top-fixed-message');
    let messageAlert = document.getElementById('stream-message-notif');

    processNotif.classList.add('visible');

    messageAlert.innerHTML = message;

    messageAlert.setAttribute("class", 'message');

    document.body.classList.add('disable-pointer');
};

export const closeMessageAlert = (message, response) => {
    let processNotif = document.querySelector('.top-fixed-message');
    let messageAlert = document.getElementById('stream-message-notif');

    messageAlert.classList.add(response);

    messageAlert.innerHTML = message;

    document.body.classList.remove('disable-pointer');

    setTimeout(function () {
        processNotif.classList.remove('visible');
    }, 800);
};