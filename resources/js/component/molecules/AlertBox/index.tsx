import React from 'react';
import { AlertBoxProps } from '../../../props/props';
import Button from '../../atoms/Buttons/Button';
import FAS from '../../atoms/Icon/FAS';
import P from '../../atoms/Typography/P';

const AlertBox: React.FC<React.PropsWithChildren<AlertBoxProps>> = (
  props: AlertBoxProps,
): JSX.Element => (
  <div className="alert alert-block alert-error fade in">
    <Button type="button" className="close" data-dismiss="alert" />
    <h4 className="alert-heading">
      <FAS className="exclamation-circle" /> AlertBox!
    </h4>
    <P className="" label={props.text} />
    <div className="button-set">
      <button className="btn btn-danger btn-cons" type="button">
        Do this
      </button>
      <button className="btn btn-white btn-cons" type="button">
        Or this
      </button>
    </div>
  </div>
);

export default AlertBox;
