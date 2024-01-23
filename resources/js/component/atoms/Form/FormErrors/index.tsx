import { FormErrorProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';

const FormErrors: React.FC<React.PropsWithChildren<FormErrorProps>> = (
  props: FormErrorProps,
): JSX.Element => (
  <ErrorBoundary>
    <div className="formErrors">
      {Object.keys(props.formErrors).map((fieldName, i) => {
        if (props.formErrors[fieldName].length > 0) {
          return (
            <p key={i}>
              {fieldName} {props.formErrors[fieldName]}
            </p>
          );
        }
        return '';
      })}
    </div>
  </ErrorBoundary>
);
export default FormErrors;
