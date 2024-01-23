import React from 'react';
import { AlertInfoLineSuccessProps } from '../../../../props/props';
import Button from '../../../atoms/Buttons/Button';

const AlertInfoSuccessLine: React.FC<React.PropsWithChildren<AlertInfoLineSuccessProps>> = (
  props: AlertInfoLineSuccessProps,
): JSX.Element => (
  <div className="alert alert-success">
    {props.showButton === true || typeof props.showButton === 'undefined' ? (
      <Button className="close" dataDismiss="alert" />
    ) : (
      ''
    )}
    Success:&nbsp;
    {props.text}
  </div>
);
export default AlertInfoSuccessLine;
