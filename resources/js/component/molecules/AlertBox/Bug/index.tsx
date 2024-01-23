import React from 'react';
import { AlertBoxBugProps } from '../../../../props/props';
import Button from '../../../atoms/Buttons/Button';
import FAS from '../../../atoms/Icon/FAS';
import H5 from '../../../atoms/Typography/H5';
import P from '../../../atoms/Typography/P';

const AlertBugBox: React.FC<React.PropsWithChildren<AlertBoxBugProps>> = (
  props: AlertBoxBugProps,
): JSX.Element => (
  // @ts-ignore
  <div className="alert alert-block alert-error fade in show">
    <h4 className="alert-heading">
      <FAS className="bug" /> Bug!
    </h4>
    {props.headline !== 'undefined' ? <H5 className="alert-heading" label={props.headline} /> : ''}
    {typeof props.textarray !== 'undefined' ? (
      // eslint-disable-next-line array-callback-return
      props.textarray.map((item, idx) => {
        if (typeof item === 'object') {
          for (let i = 0; i <= item.length; i += 1) {
            if (i === 0) {
              <H5 label={item[i]} />;
            } else {
              <P key={idx} className="" label={item[i]} />;
            }
          }
        } else {
          <P key={idx} className="" label={item} />;
        }
      })
    ) : (
      <P className="" label={props.text} />
    )}
    {typeof props.errorObject !== 'undefined' ? (
      <details>
        <summary>{props.errorObject.message as string}</summary>
        <p className="">
          <strong>ColoumnNumber: </strong>
          {props.errorObject.coloumnNumber as string}
        </p>
        <p className="">
          <strong>FileName: </strong>
          {props.errorObject.fileName as string}
        </p>
        <p className="">
          <strong>LineNumber: </strong>
          {props.errorObject.lineNumber as string}
        </p>
        <p className="">
          <strong>Stack: </strong>
          {props.errorObject.stack.replace(/ /g, '\n')}
        </p>
      </details>
    ) : (
      ''
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
export default AlertBugBox;
