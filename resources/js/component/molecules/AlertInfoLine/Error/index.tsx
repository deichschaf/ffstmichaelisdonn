import React from 'react';
import { AlertInfoLineErrorProps } from '../../../../props/props';
import Button from '../../../atoms/Buttons/Button';

const AlertInfoErrorLine: React.FC<React.PropsWithChildren<AlertInfoLineErrorProps>> = (
  props: AlertInfoLineErrorProps,
): JSX.Element => {
  function showArrayObject(message) {
    if (typeof message === 'undefined') {
      return <></>;
    }
    if (typeof message === 'object') {
      const keys = [];
      const values = [];
      Object.keys(message).map((key, idx) => keys.push(key as never));
      Object.values(message).map((value, idx) => values.push(value as never));
      const entries = [];
      for (let i = 0; i < keys.length; i += 1) {
        entries.push(`${keys[i]}: ${values[i]}` as never);
      }
      return entries.map((entry, idx) => <li key={idx}>{entry}</li>);
    }
    return message.map((txt, idx) => <li key={idx}>{txt}</li>);
  }

  function showErrorMessage(message) {
    if (typeof message === 'string') {
      return message;
    }
    return <ul>{showArrayObject(message)}</ul>;
  }

  return (
    <div className="alert alert-error">
      {props.showButton === true ? <Button className="close" dataDismiss="alert" /> : ''}
      Achtung: {showErrorMessage(props.text)}
    </div>
  );
};
export default AlertInfoErrorLine;
