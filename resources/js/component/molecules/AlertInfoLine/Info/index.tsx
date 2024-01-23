import React from 'react';
import { AlertInfoLineInfoProps } from '../../../../props/props';
import Button from '../../../atoms/Buttons/Button';

const AlertInfoInfoLine: React.FC<React.PropsWithChildren<AlertInfoLineInfoProps>> = (
  props: AlertInfoLineInfoProps,
): JSX.Element => (
  <div className="alert alert-info">
    {props.showButton === true || typeof props.showButton === 'undefined' ? (
      <Button className="close" dataDismiss="alert" />
    ) : (
      ''
    )}
    Info:&nbsp;
    {props.text}
  </div>
);
export default AlertInfoInfoLine;
