import React, { useEffect, useState } from 'react';
import { CountdownProps } from '../../../props/props';
import P from '../../atoms/Typography/P';
import ErrorBoundary from '../../organisms/errorboundary';

const EmergencyLastAlarmCountdown: React.FC<CountdownProps> = (
  props: CountdownProps,
): JSX.Element => {
  // const targetTime = new Date('2023-02-11').getTime();
  const [currentTime, setCurrentTime] = useState(Date.now());

  useEffect(() => {
    const interval = setInterval(() => {
      setCurrentTime(Date.now());
    }, 1000);
    return () => clearInterval(interval);
  }, []);

  if (typeof props.datetime !== 'string') {
    return <></>;
  }
  const lastAlarmTime = Date.parse(props.datetime);
  const timeBetween = currentTime - lastAlarmTime;
  if (timeBetween <= 0) {
    return <></>;
  }
  const seconds = Math.floor((timeBetween / 1000) % 60);
  const minutes = Math.floor((timeBetween / 1000 / 60) % 60);
  const hours = Math.floor((timeBetween / (1000 * 60 * 60)) % 24);
  const days = Math.floor(timeBetween / (1000 * 60 * 60 * 24));

  return (
    <ErrorBoundary>
      <p>
        {props.label} Letzte Alarmierung war vor
        <span> {days} Tage</span>
        <span> {hours} Stunden</span>
        <span> {minutes} Minuten</span>
      </p>
    </ErrorBoundary>
  );
};
export default EmergencyLastAlarmCountdown;
