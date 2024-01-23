import React from 'react';
import { FireTruckImageProps } from '../../../props/props';
import PictureSourcSet from '../../atoms/Picture/SourceSet';
import ErrorBoundary from '../../organisms/errorboundary';

const FireTruckImage: React.FC<React.PropsWithChildren<FireTruckImageProps>> = (
  props: FireTruckImageProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.id === 'undefined') {
    return <></>;
  }

  if (typeof props.data.img === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <PictureSourcSet
        path={props.data.path}
        img={props.data.img}
        srcset={props.data.srcset}
        alt={props.data.alt}
        title={props.data.title}
      />
    </ErrorBoundary>
  );
};
export default FireTruckImage;
