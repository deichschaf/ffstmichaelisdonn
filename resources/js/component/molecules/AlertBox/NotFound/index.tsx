import React from 'react';
import { AlertBoxNotFoundProps } from '../../../../props/props';
import FAS from '../../../atoms/Icon/FAS';
import H5 from '../../../atoms/Typography/H5';
import P from '../../../atoms/Typography/P';

const AlertNotFoundBox: React.FC<React.PropsWithChildren<AlertBoxNotFoundProps>> = (
  props: AlertBoxNotFoundProps,
): JSX.Element => {
  function makeHeadline(props) {
    if (typeof props.headline === 'undefined') {
      return '';
    }
    if (props.headline === '') {
      return '';
    }
    return <H5 className="alert-heading" label={props.headline} />;
  }

  function makePBlock(props) {
    if (typeof props.textarray === 'undefined') {
      return '';
    }
    const datas = [] as any;
    // eslint-disable-next-line array-callback-return
    props.textarray.map((item, idx) => {
      if (typeof item === 'object') {
        for (let i = 0; i <= item.length; i += 1) {
          if (i === 0) {
            datas.push([<H5 label={item[i]} />]);
          } else {
            datas.push([<P key={idx} className="" label={item[i]} />]);
          }
        }
      } else {
        datas.push([<P key={idx} className="" label={item} />]);
      }
    });
    return datas.map((item, idx) => <>{item}</>);
  }

  function makeP(props) {
    if (typeof props.text === 'undefined') {
      return '';
    }
    if (props.text === '') {
      return '';
    }
    return <P className="" label={props.text} />;
  }

  function makeErrorDetails(props) {
    if (typeof props.errorObject === 'undefined') {
      return '';
    }
    return (
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
          {/* eslint-disable-next-line react/no-danger */}
          <span
            dangerouslySetInnerHTML={{
              __html: props.errorObject.stack.replace(/(?:\r\n|\r|\n)/g, '<br />'),
            }}
          />
        </p>
      </details>
    );
  }

  function makeButtons(props) {
    if (typeof props.showButton === 'undefined') {
      return '';
    }
    if (props.showButton === false) {
      return '';
    }
    return (
      <div className="button-set">
        <button className="btn btn-danger btn-cons" type="button">
          Do this
        </button>
        <button className="btn btn-white btn-cons" type="button">
          Or this
        </button>
      </div>
    );
  }

  return (
    <div className="alert alert-block alert-warning fade in show">
      <h4 className="alert-heading">
        <FAS className="exclamation-triangle" /> Nicht gefunden!
      </h4>
      {makeHeadline(props)}
      {makePBlock(props)}
      {makeP(props)}
      {makeErrorDetails(props)}
      {makeButtons(props)}
    </div>
  );
};

export default AlertNotFoundBox;
