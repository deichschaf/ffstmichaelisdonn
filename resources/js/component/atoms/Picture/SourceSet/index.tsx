import React from 'react';
import { AllPictureProps } from '../../../../props/props';
import { checkValueUndefineReturnString } from '../../../component_helper';

const PictureSourcSet: React.FC<React.PropsWithChildren<AllPictureProps>> = (
  props: AllPictureProps,
): JSX.Element => {
  if (
    typeof props.path === 'undefined' &&
    typeof props.img === 'undefined' &&
    typeof props.images === 'undefined'
  ) {
    return <></>;
  }

  const { path, img } = props;
  let alt_text: string | undefined = '';

  let imgpath: string | undefined = '';
  const pathplain = checkValueUndefineReturnString(path);
  const imgplain = checkValueUndefineReturnString(img);
  if (pathplain === '' && imgplain === '' && typeof props.images === 'undefined') {
    return <></>;
  }
  if (pathplain !== '' && imgplain !== '') {
    imgpath = pathplain + imgplain;
  }
  if (pathplain === '' && imgplain !== '') {
    imgpath = img;
  }
  if (props.alt !== '') {
    alt_text = props.alt;
  }
  if (props.img === null && props.images === null) {
    return <></>;
  }
  return (
    <picture className={props.className}>
      {typeof props.images !== 'undefined' && props.images !== null
        ? props.images.map((item, idx) => (
            <source
              key={idx}
              srcSet={props.path + item.image}
              type={`image/${item.type}`}
              media={item.media}
            />
          ))
        : ''}
      <img loading="lazy" src={imgpath} alt={alt_text} title={props.title} />
    </picture>
  );
};
export default PictureSourcSet;
