import React, { useEffect, useState } from 'react';
import { CountdownProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';

const Countdown: React.FC<CountdownProps> = (props: CountdownProps): JSX.Element => {
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
  const targetTime = Date.parse(props.datetime);
  const timeBetween = targetTime - currentTime;
  if (timeBetween <= 0) {
    return <></>;
  }
  const seconds = Math.floor((timeBetween / 1000) % 60);
  const minutes = Math.floor((timeBetween / 1000 / 60) % 60);
  const hours = Math.floor((timeBetween / (1000 * 60 * 60)) % 24);
  const days = Math.floor(timeBetween / (1000 * 60 * 60 * 24));

  return (
    <ErrorBoundary>
      <>
        <p>
          Es sind noch
          {days > 0 ? <span> {days} Tage</span> : <></>}
          <span> {hours} Stunden</span>
          <span> {minutes} Minuten</span>
          <span> {seconds} Sekunden</span>
        </p>
      </>
    </ErrorBoundary>
  );
};
export default Countdown;
