import React from 'react';
import ErrorBoundary from '../../../../../component/organisms/errorboundary';
import { IImageUplaoderImageList } from '../../../../../props/props';
import { Link } from 'react-router-dom';

const ImageUploaderImageList: React.FC<React.PropsWithChildren<IImageUplaoderImageList>> = (
  props: IImageUplaoderImageList
): JSX.Element => {
  if (props.imageInfos === null || props.imageInfos === null) {
    return <></>;
  }
  if (props.imageInfos.length > 0) {
    return (
      <ErrorBoundary>
        <div className="card mt-3">
          <div className="card-header">List of Files</div>
          <ul className="list-group list-group-flush">
            {props.imageInfos &&
              props.imageInfos.map((img, index) => (
                <li className="list-group-item" key={index}>
                  <Link to={img.url}>{img.name}</Link>
                  <img src={img.url} alt={img.name} height="80px" />
                </li>
              ))}
          </ul>
        </div>
      </ErrorBoundary>
    );
  }
  return <></>;
};
export default ImageUploaderImageList;
