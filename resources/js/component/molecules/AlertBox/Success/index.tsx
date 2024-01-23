import React from 'react';
import { AlertBoxSuccessProps } from '../../../../props/props';
import Button from '../../../atoms/Buttons/Button';
import FAS from '../../../atoms/Icon/FAS';
import H5 from '../../../atoms/Typography/H5';
import P from '../../../atoms/Typography/P';

const AlertSuccessBox: React.FC<React.PropsWithChildren<AlertBoxSuccessProps>> = (
  props: AlertBoxSuccessProps,
): JSX.Element => (
  <div className="alert alert-block alert-success fade in">
    <Button type="button" className="close" data-dismiss="alert" />
    <h4 className="alert-heading">
      <FAS className="exclamation-circle" /> Success!
    </h4>
    {props.headline !== 'undefined' ? <H5 className="alert-heading" label={props.headline} /> : ''}
    {props.textarray !== 'undefined' ? (
      props.textarray.map((item, idx) => <P key={idx} className="" label={item} />)
    ) : (
      <P className="" label={props.text} />
    )}
    {props.showButton === true || typeof props.showButton === 'undefined' ? (
      <div className="button-set">
        <button className="btn btn-danger btn-cons" type="button">
          Do this
        </button>
        <button className="btn btn-white btn-cons" type="button">
          Or this
        </button>
      </div>
    ) : (
      ''
    )}
  </div>
);

export default AlertSuccessBox;
