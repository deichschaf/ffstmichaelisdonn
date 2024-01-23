export function getDateWeekName(date: string): string {
  const daynumber = new Date(date).getDay();
  const days = ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'];
  return days[daynumber];
}

export function getGermanMonthName(month: string): string {
  let monthname: string;
  switch (month) {
    case '01':
    case '1':
      monthname = 'Januar';
      break;
    case '02':
    case '2':
      monthname = 'Februar';
      break;
    case '03':
    case '3':
      monthname = 'März';
      break;
    case '04':
    case '4':
      monthname = 'April';
      break;
    case '05':
    case '5':
      monthname = 'Mai';
      break;
    case '06':
    case '6':
      monthname = 'Juni';
      break;
    case '07':
    case '7':
      monthname = 'Juli';
      break;
    case '08':
    case '8':
      monthname = 'August';
      break;
    case '09':
    case '9':
      monthname = 'September';
      break;
    case '10':
      monthname = 'Oktober';
      break;
    case '11':
      monthname = 'November';
      break;
    case '12':
      monthname = 'Dezember';
      break;
    default:
      monthname = 'FEHLER!!';
  }
  return monthname;
}

export function getDateGerman(date: string, format: string = 'short'): string {
  const newdate = date.split('-');
  if (format === 'short') {
    return newdate[2] + '.' + newdate[1] + '.' + newdate[0];
  }
  return newdate[2] + '.' + getGermanMonthName(newdate[1]) + ' ' + newdate[0];
}

export function getHourMinutes(time: string): string {
  const timestring = time.split(':');
  return timestring[0] + ':' + timestring[1];
}
