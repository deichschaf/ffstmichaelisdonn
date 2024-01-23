import React from 'react';
import { AlertInfoLineWarningProps } from '../../../../props/props';
import Button from '../../../atoms/Buttons/Button';

const AlertInfoWarningLine: React.FC<React.PropsWithChildren<AlertInfoLineWarningProps>> = (
  props: AlertInfoLineWarningProps,
): JSX.Element => (
  <div className="alert alert-warning">
    {props.showButton === true || typeof props.showButton === 'undefined' ? (
      <Button className="close" dataDismiss="alert" />
    ) : (
      ''
    )}
    Warning:&nbsp;
    {props.text}
  </div>
);
export default AlertInfoWarningLine;
