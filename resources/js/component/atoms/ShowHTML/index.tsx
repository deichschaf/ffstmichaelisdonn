import React from 'react';
import { ShowHTMLProps } from '../../../props/props';

const ShowHTML: React.FC<React.PropsWithChildren<ShowHTMLProps>> = (
  props: ShowHTMLProps,
): JSX.Element => {
  function read(html) {
    return {
      __html: html,
    };
  }
  return (
    // eslint-disable-next-line react/no-danger
    <div dangerouslySetInnerHTML={read(props.html)} />
  );
};
export default ShowHTML;
