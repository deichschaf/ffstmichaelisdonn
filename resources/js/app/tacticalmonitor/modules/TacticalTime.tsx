import React, { useState } from 'react';
import { TacticalTimeProps } from '../../../props/props';
import ErrorBoundary from '../../../component/organisms/errorboundary';

const TacticalTime: React.FC<React.PropsWithChildren<TacticalTimeProps>> = (
  props: TacticalTimeProps
): JSX.Element => {
  const [getTacticalTime, setTaticalTime] = useState<string>('');
  const [getLocalDate, setLocalDate] = useState<string>('');
  const [getLocalTime, setLocalTime] = useState<string>('');

  function getTime() {
    let timenow = new Date();
    let Hours = timenow.getHours();
    let Minutes = timenow.getMinutes();
    let Seconds = timenow.getSeconds();
    let Day = timenow.getDate();
    let Month = timenow.getMonth() + 1;
    // @ts-ignore
    let Year = timenow.getYear();
    let timestring = (Hours < 10 ? '0' : '') + Hours;
    timestring += (Minutes < 10 ? ':0' : ':') + Minutes;
    timestring += (Seconds < 10 ? ':0' : ':') + Seconds;
    setLocalTime(timestring);
    if (Year > 99 && Year < 1900) {
      Year += 1900;
    }
    let datestring = (Day < 10 ? '0' : '') + Day;
    datestring += (Month < 10 ? '.0' : '.') + Month;
    datestring += '.' + Year;
    setLocalDate(datestring);

    let month = {
      0: 'JAN',
      1: 'FEB',
      2: 'MAR',
      3: 'APR',
      4: 'MAY',
      5: 'JUN',
      6: 'JUL',
      7: 'AUG',
      8: 'SEP',
      9: 'OCT',
      10: 'NOV',
      11: 'DEC',
    };
    let n = month[timenow.getMonth()];
    let tactical =
      (Day < 10 ? '0' : '') +
      Day +
      (Hours < 10 ? '0' : '') +
      Hours +
      (Minutes < 10 ? '0' : '') +
      Minutes +
      n +
      Year.toString().substring(2);
    setTaticalTime(tactical);
  }

  setTimeout('getTime()', 10000);
  return (
    <ErrorBoundary>
      <div className="timearea">
        <fieldset>
          <legend>Taktische Zeit</legend>
          <span>{getTacticalTime}</span>
          <span className="datumzeit">
            {getLocalDate} <span className="time_trenner">-</span> {getLocalTime}
          </span>
        </fieldset>
      </div>
    </ErrorBoundary>
  );
};
export default TacticalTime;
