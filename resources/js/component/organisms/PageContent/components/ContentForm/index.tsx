import React from 'react';
import { ContentFormProps } from '../../../../../props/props';

const ContentForm: React.FC<React.PropsWithChildren<ContentFormProps>> = (
  props: ContentFormProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  return <></>;
};
export default ContentForm;
